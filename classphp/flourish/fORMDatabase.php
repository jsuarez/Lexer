<?php
/**
 * Holds a single instance of the fDatabase class and provides database manipulation functionality for ORM code
 * 
 * @copyright  Copyright (c) 2007-2009 Will Bond, others
 * @author     Will Bond [wb] <will@flourishlib.com>
 * @author     Craig Ruksznis, iMarc LLC [cr-imarc] <craigruk@imarc.net>
 * @license    http://flourishlib.com/license
 * 
 * @package    Flourish
 * @link       http://flourishlib.com/fORMDatabase
 * 
 * @version    1.0.0b15
 * @changes    1.0.0b15  Streamlined intersection operator SQL and added support for the second value being NULL [wb, 2009-09-21]
 * @changes    1.0.0b14  Added support for the intersection operator `><` to ::createWhereClause() [wb, 2009-07-13]
 * @changes    1.0.0b13  Added support for the `AND LIKE` operator `&~` to ::createWhereClause() [wb, 2009-07-09]
 * @changes    1.0.0b12  Added support for the `NOT LIKE` operator `!~` to ::createWhereClause() [wb, 2009-07-08]
 * @changes    1.0.0b11  Added support for concatenated columns to ::escapeBySchema() [cr-imarc, 2009-06-19]
 * @changes    1.0.0b10  Updated ::createWhereClause() to properly handle NULLs for arrays of values when doing = and != comparisons [wb, 2009-06-17]
 * @changes    1.0.0b9   Changed replacement values in preg_replace() calls to be properly escaped [wb, 2009-06-11]
 * @changes    1.0.0b8   Fixed a bug with ::creatingWhereClause() where a null value would not be escaped property [wb, 2009-05-12]
 * @changes    1.0.0b7   Fixed a bug where an OR condition in ::createWhereClause() could not have one of the values be an array [wb, 2009-04-22]
 * @changes    1.0.0b6   ::insertFromAndGroupByClauses() will no longer wrap ungrouped columns if in a CAST or CASE statement for ORDER BY clauses of queries with a GROUP BY clause [wb, 2009-03-23]
 * @changes    1.0.0b5   Fixed ::parseSearchTerms() to include stop words when they are the only thing in the search string [wb, 2008-12-31]
 * @changes    1.0.0b4   Fixed a bug where loading a related record in the same table through a one-to-many relationship caused recursion [wb, 2008-12-24]
 * @changes    1.0.0b3   Fixed a bug from 1.0.0b2 [wb, 2008-12-05]
 * @changes    1.0.0b2   Added support for != and <> to ::createWhereClause() and ::createHavingClause() [wb, 2008-12-04]
 * @changes    1.0.0b    The initial implementation [wb, 2007-08-04]
 */
class fORMDatabase
{
	// The following constants allow for nice looking callbacks to static methods
	const addTableToKeys              = 'fORMDatabase::addTableToKeys';
	const addTableToValues            = 'fORMDatabase::addTableToValues';
	const attach                      = 'fORMDatabase::attach';
	const createFromClauseFromJoins   = 'fORMDatabase::createFromClauseFromJoins';
	const createHavingClause          = 'fORMDatabase::createHavingClause';
	const createOrderByClause         = 'fORMDatabase::createOrderByClause';
	const createPrimaryKeyWhereClause = 'fORMDatabase::createPrimaryKeyWhereClause';
	const createWhereClause           = 'fORMDatabase::createWhereClause';
	const escapeBySchema              = 'fORMDatabase::escapeBySchema';
	const escapeByType                = 'fORMDatabase::escapeByType';
	const insertFromAndGroupByClauses = 'fORMDatabase::insertFromAndGroupByClauses';
	const reset                       = 'fORMDatabase::reset';
	const retrieve                    = 'fORMDatabase::retrieve';
	const splitHavingConditions       = 'fORMDatabase::splitHavingConditions';
	
	
	/**
	 * The instance of fDatabase
	 * 
	 * @var fDatabase
	 */
	static private $database_object = NULL;
	
	
	/**
	 * Prepends the table to the keys of the array
	 * 
	 * @internal
	 * 
	 * @param  string $table  The table to prepend
	 * @param  array  $array  The array to modify
	 * @return array  The modified array
	 */
	static public function addTableToKeys($table, $array)
	{
		$modified_array = array();
		foreach ($array as $key => $value) {
			if (preg_match('#^\w+$#D', $key)) {
				$modified_array[$table . '.' . $key] = $value;
			} else {
				$modified_array[$key] = $value;
			}
		}
		return $modified_array;
	}
	
	
	/**
	 * Prepends the table to the values of the array
	 * 
	 * @internal
	 * 
	 * @param  string $table  The table to prepend
	 * @param  array  $array  The array to modify
	 * @return array  The modified array
	 */
	static public function addTableToValues($table, $array)
	{
		$modified_array = array();
		foreach ($array as $key => $value) {
			if (preg_match('#^\w+$#D', $value)) {
				$modified_array[$key] = $table . '.' . $value;
			} else {
				$modified_array[$key] = $value;
			}
		}
		return $modified_array;
	}
	
	
	/**
	 * Allows attaching an fDatabase-compatible object as the database singleton for ORM code
	 * 
	 * @param  fDatabase $database  An object that is compatible with fDatabase
	 * @return void
	 */
	static public function attach($database)
	{
		self::$database_object = $database;
	}
	
	
	/**
	 * Translated the where condition for a single column into a SQL clause
	 * 
	 * @param  string $table     The table to create the condition for
	 * @param  string $column    The column to store the value in, may also be shorthand column name like `table.column` or `table=>related_table.column`
	 * @param  mixed  $values    The value(s) to escape
	 * @param  string $operator  Should be `'='`, `'!='`, `'!'`, `'<>'`, `'<'`, `'<='`, `'>'`, `'>='`, `'IN'`, `'NOT IN'`
	 * @return string  The SQL clause for the column, values and operator specified
	 */
	static private function createColumnCondition($table, $column, $values, $operator)
	{
		settype($values, 'array');
		
		// More than one value
		if (sizeof($values) > 1) {
			switch ($operator) {
				case '=':
					$condition = array();
					$has_null  = FALSE;
					foreach ($values as $value) {
						if ($value === NULL) {
							$has_null = TRUE;
							continue;	
						}
						$condition[] = self::escapeBySchema($table, $column, $value);
					}
					$sql = $column . ' IN (' . join(', ', $condition) . ')';
					if ($has_null) {
						$sql = '(' . $column . ' IS NULL OR ' . $sql . ')';	
					}
					break;
					
				case '!':
					$condition = array();
					$has_null  = FALSE;
					foreach ($values as $value) {
						if ($value === NULL) {
							$has_null = TRUE;
							continue;	
						}
						$condition[] = self::escapeBySchema($table, $column, $value);
					}
					$sql = $column . ' NOT IN (' . join(', ', $condition) . ')';
					if ($has_null) {
						$sql = '(' . $column . ' IS NOT NULL AND ' . $sql . ')';	
					}
					break;
					
				case '~':
					$condition = array();
					foreach ($values as $value) {
						$condition[] = $column . self::retrieve()->escape(' LIKE %s', '%' . $value . '%');
					}
					$sql = '(' . join(' OR ', $condition) . ')';
					break;
				
				case '&~':
					$condition = array();
					foreach ($values as $value) {
						$condition[] = $column . self::retrieve()->escape(' LIKE %s', '%' . $value . '%');
					}
					$sql = '(' . join(' AND ', $condition) . ')';
					break;
				
				case '!~':
					$condition = array();
					foreach ($values as $value) {
						$condition[] = $column . self::retrieve()->escape(' NOT LIKE %s', '%' . $value . '%');
					}
					$sql = '(' . join(' AND ', $condition) . ')';
					break;
					
				default:
					throw new fProgrammerException(
						'An invalid array comparison operator, %s, was specified for an array of values',
						$operator
					);
					break;
			}
			
		// A single value
		} else {
			if ($values === array()) {
				$value = NULL;
			} else {
				$value = current($values);
			}
			
			switch ($operator) {
				case '=':
				case '<':
				case '<=':
				case '>':
				case '>=':
					$sql = $column . self::escapeBySchema($table, $column, $value, $operator);
					break;
					
				case '!':
					if ($value !== NULL) {
						$sql = '(' . $column . self::escapeBySchema($table, $column, $value, '<>') . ' OR ' . $column . ' IS NULL)';
					} else {
						$sql = $column . self::escapeBySchema($table, $column, $value, '<>');
					}
					break;
					
				case '~':
					$sql = $column . self::retrieve()->escape(' LIKE %s', '%' . $value . '%');
					break;
				
				case '!~':
					$sql = $column . self::retrieve()->escape(' NOT LIKE %s', '%' . $value . '%');
					break;
					
				default:
					throw new fProgrammerException(
						'An invalid comparison operator, %s, was specified for a single value',
						$operator
					);
					break;
			}
		}
		
		return $sql;	
	}
	
	
	/**
	 * Creates a `FROM` clause from a join array
	 * 
	 * @internal
	 * 
	 * @param  array $joins  The joins to create the `FROM` clause out of
	 * @return string  The from clause (does not include the word `'FROM'`)
	 */
	static public function createFromClauseFromJoins($joins)
	{
		$sql = '';
		
		foreach ($joins as $join) {
			// Here we handle the first table in a join
			if ($join['join_type'] == 'none') {
				$sql .= $join['table_name'];
				if ($join['table_alias'] != $join['table_name']) {
					$sql .= ' AS ' . $join['table_alias'];
				}
			
			// Here we handle all other joins
			} else {
				$sql .= ' ' . strtoupper($join['join_type']) . ' ' . $join['table_name'];
				if ($join['table_alias'] != $join['table_name']) {
					$sql .= ' AS ' . $join['table_alias'];
				}
				if (isset($join['on_clause_type'])) {
					if ($join['on_clause_type'] == 'simple_equation') {
						$sql .= ' ON ' . $join['on_clause_fields'][0] . ' = ' . $join['on_clause_fields'][1];
						
					} else {
						$sql .= ' ON ' . $join['on_clause'];
					}
				}
			}
		}
		
		return $sql;
	}
	
	
	/**
	 * Creates a `HAVING` clause from an array of conditions
	 * 
	 * @internal
	 * 
	 * @param  array  $conditions  The array of conditions - see fRecordSet::build() for format
	 * @return string  The SQL `HAVING` clause
	 */
	static public function createHavingClause($conditions)
	{
		$sql = array();
		
		foreach ($conditions as $expression => $value) {
			if (in_array(substr($expression, -2), array('<=', '>=', '!=', '<>'))) {
				$operator   = strtr(
					substr($expression, -2),
					array(
						'<>' => '!',
						'!=' => '!'
					)
				);
				$expression = substr($expression, 0, -2);
			} else {
				$operator   = substr($expression, -1);
				$expression = substr($expression, 0, -1);
			}
			
			if (is_object($value)) {
				if (is_callable(array($value, '__toString'))) {
					$value = $value->__toString();	
				} else {
					$value = (string) $value;
				}
			}
			
			if (is_array($value)) {
				
				switch ($operator) {
					case '=':
						$condition = array();
						foreach ($values as $value) {
							$condition[] = self::escapeByType($value);
						}
						$sql[] = $expression . ' IN (' . join(', ', $condition) . ')';
						break;
						
					case '!':
						$condition = array();
						foreach ($values as $value) {
							$condition[] = self::escapeByType($value);
						}
						$sql[] = $expression . ' NOT IN (' . join(', ', $condition) . ')';
						break;

					default:
						throw new fProgrammerException(
							'An invalid array comparison operator, %s, was specified',
							$operator
						);
						break;
				}
					
			} else {
				
				if (!in_array($operator, array('=', '!', '~', '<', '<=', '>', '>='))) {
					throw new fProgrammerException(
						'An invalid comparison operator, %s, was specified',
						$operator
					); 	
				}
				
				$sql[] = $expression . self::escapeByType($value, $operator);	
			}
		}
		
		return join(' AND ', $sql);
	}	
	
	
	/**
	 * Creates join information for the table shortcut provided
	 * 
	 * @internal
	 * 
	 * @param  string $table          The primary table
	 * @param  string $table_alias    The primary table alias
	 * @param  string $related_table  The related table
	 * @param  string $route          The route to the related table
	 * @param  array  &$joins         The names of the joins that have been created
	 * @param  array  &$used_aliases  The aliases that have been used
	 * @return string  The name of the significant join created
	 */
	static private function createJoin($table, $table_alias, $related_table, $route, &$joins, &$used_aliases)
	{
		$routes = fORMSchema::getRoutes($table, $related_table);
						
		if (!isset($routes[$route])) {
			throw new fProgrammerException(
				'An invalid route, %1$s, was specified for the relationship from %2$s to %3$s',
				$route,
				$table,
				$related_table
			);
		}
		
		if (isset($joins[$table . '_' . $related_table . '{' . $route . '}'])) {
			return  $table . '_' . $related_table . '{' . $route . '}';
		}
		
		// If the route uses a join table
		if (isset($routes[$route]['join_table'])) {
			$join = array(
				'join_type' => 'LEFT JOIN',
				'table_name' => $routes[$route]['join_table'],
				'table_alias' => self::createNewAlias($routes[$route]['join_table'], $used_aliases),
				'on_clause_type' => 'simple_equation',
				'on_clause_fields' => array()
			);
			
			$join2 = array(
				'join_type' => 'LEFT JOIN',
				'table_name' => $related_table,
				'table_alias' => self::createNewAlias($related_table, $used_aliases),
				'on_clause_type' => 'simple_equation',
				'on_clause_fields' => array()
			);
			
			if ($table != $related_table) {
				$join['on_clause_fields'][]  = $table_alias . '.' . $routes[$route]['column'];
				$join['on_clause_fields'][]  = $join['table_alias'] . '.' . $routes[$route]['join_column'];
				$join2['on_clause_fields'][] = $join['table_alias'] . '.' . $routes[$route]['join_related_column'];
				$join2['on_clause_fields'][] = $join2['table_alias'] . '.' . $routes[$route]['related_column'];
			} else {
				$join['on_clause_fields'][]  = $table_alias . '.' . $routes[$route]['column'];
				$join['on_clause_fields'][]  = $join['table_alias'] . '.' . $routes[$route]['join_related_column'];
				$join2['on_clause_fields'][] = $join['table_alias'] . '.' . $routes[$route]['join_column'];
				$join2['on_clause_fields'][] = $join2['table_alias'] . '.' . $routes[$route]['related_column'];
			}
			
			$joins[$table . '_' . $related_table . '{' . $route . '}_join'] = $join;
			$joins[$table . '_' . $related_table . '{' . $route . '}'] = $join2;
				
		// If the route is a direct join
		} else {
			
			$join = array(
				'join_type' => 'LEFT JOIN',
				'table_name' => $related_table,
				'table_alias' => self::createNewAlias($related_table, $used_aliases),
				'on_clause_type' => 'simple_equation',
				'on_clause_fields' => array()
			);
			
			$join['on_clause_fields'][] = $table_alias . '.' . $routes[$route]['column'];
			$join['on_clause_fields'][] = $join['table_alias'] . '.' . $routes[$route]['related_column'];
		
			$joins[$table . '_' . $related_table . '{' . $route . '}'] = $join;
		
		}
		
		return $table . '_' . $related_table . '{' . $route . '}';
	}
	
	
	/**
	 * Creates a new table alias
	 * 
	 * @internal
	 * 
	 * @param  string $table          The table to create an alias for
	 * @param  array  &$used_aliases  The aliases that have been used
	 * @return string  The alias to use for the table
	 */
	static private function createNewAlias($table, &$used_aliases)
	{
		if (!in_array($table, $used_aliases)) {
			$used_aliases[] = $table;
			return $table;
		}
		$i = 1;
		while(in_array($table . $i, $used_aliases)) {
			$i++;
		}
		$used_aliases[] = $table . $i;
		return $table . $i;
	}
	
	
	/**
	 * Creates an `ORDER BY` clause from an array of columns/expressions and directions
	 * 
	 * @internal
	 * 
	 * @param  string $table      The table any ambigious column references will refer to
	 * @param  array  $order_bys  The array of order bys to use - see fRecordSet::build() for format
	 * @return string  The SQL `ORDER BY` clause
	 */
	static public function createOrderByClause($table, $order_bys)
	{
		$order_bys = self::addTableToKeys($table, $order_bys);
		$sql = array();
		
		foreach ($order_bys as $column => $direction) {
			if ((!is_string($column) && !is_object($column) && !is_numeric($column)) || !strlen(trim($column))) {
				throw new fProgrammerException(
					'An invalid sort column, %s, was specified',
					$column
				);
			}
			
			$direction = strtoupper($direction);
			if (!in_array($direction, array('ASC', 'DESC'))) {
				throw new fProgrammerException(
					'An invalid direction, %s, was specified',
					$direction
				);
			}
			
			if (preg_match('#^(?:\w+(?:\{\w+\})?=>)?(\w+)(?:\{\w+\})?\.(\w+)$#D', $column, $matches)) {
				$column_type = fORMSchema::retrieve()->getColumnInfo($matches[1], $matches[2], 'type');
				if (in_array($column_type, array('varchar', 'char', 'text'))) {
					$sql[] = 'LOWER(' . $column . ') ' . $direction;
				} else {
					$sql[] = $column . ' ' . $direction;
				}
			} else {
				$sql[] = $column . ' ' . $direction;
			}
		}
		
		return join(', ', $sql);
	}
	
	
	/**
	 * Creates a `WHERE` clause condition for primary keys of the table specified
	 * 
	 * This method requires the `$primary_keys` parameter to be one of:
	 * 
	 *  - A scalar value for a single-column primary key
	 *  - An array of values for a single-column primary key
	 *  - An associative array of values for a multi-column primary key (`column => value`)
	 *  - An array of associative arrays of values for a multi-column primary key (`key => array(column => value)`)
	 * 
	 * If you are looking to build a primary key where clause from the `$values`
	 * and `$old_values` arrays, please see ::createPrimaryKeyWhereClause()
	 * 
	 * @internal
	 * 
	 * @param  string $table         The table to build the where clause for
	 * @param  string $table_alias   The alias for the table
	 * @param  array  &$values       The values array for the fActiveRecord object
	 * @param  array  &$old_values   The old values array for the fActiveRecord object
	 * @return string  The `WHERE` clause that will specify the fActiveRecord as it currently exists in the database
	 */
	static public function createPrimaryKeyWhereClause($table, $table_alias, &$values, &$old_values)
	{
		$primary_keys = fORMSchema::retrieve()->getKeys($table, 'primary');
		
		$sql = '';
		foreach ($primary_keys as $primary_key) {
			if ($sql) { $sql .= " AND "; }
			
			$value = (isset($old_values[$primary_key])) ? $old_values[$primary_key][0] : $values[$primary_key];
			
			$sql  .= $table . '.' . $primary_key . fORMDatabase::escapeBySchema($table, $primary_key, $value, '=');
		}
		
		return $sql;
	}
	
	
	/**
	 * Creates a `WHERE` clause from an array of conditions
	 * 
	 * @internal
	 * 
	 * @param  string $table       The table any ambigious column references will refer to
	 * @param  array  $conditions  The array of conditions - see fRecordSet::build() for format
	 * @return string  The SQL `WHERE` clause
	 */
	static public function createWhereClause($table, $conditions)
	{
		$sql = array();
		foreach ($conditions as $column => $values) {
			
			if (in_array(substr($column, -2), array('<=', '>=', '!=', '<>', '!~', '&~', '><'))) {
				$operator = strtr(
					substr($column, -2),
					array(
						'<>' => '!',
						'!=' => '!'
					)
				);
				$column   = substr($column, 0, -2);
			} else {
				$operator = substr($column, -1);
				$column   = substr($column, 0, -1);
			}
			
			if (!is_object($values)) {
				settype($values, 'array');
			} else {
				$values = array($values);	
			}
			if (!$values) { $values = array(NULL); }
			
			$new_values = array();
			foreach ($values as $value) {
				if (is_object($value) && is_callable(array($value, '__toString'))) {
					$value = $value->__toString();
				} elseif (is_object($value)) {
					$value = (string) $value;	
				}
				$new_values[] = $value;
			}
			$values = $new_values;
			
			// Multi-column condition
			if (preg_match('#(?<!\|)\|(?!\|)#', $column)) {
				$columns   = explode('|', $column);
				$operators = array();
				
				foreach ($columns as &$_column) {
					if (in_array(substr($_column, -2), array('<=', '>=', '!=', '<>', '!~', '&~'))) {
						$operators[] = strtr(
							substr($_column, -2),
							array(
								'<>' => '!',
								'!=' => '!'
							)
						);
						$_column     = substr($_column, 0, -2);
					} elseif (!ctype_alnum(substr($_column, -1))) {
						$operators[] = substr($_column, -1);
						$_column     = substr($_column, 0, -1);
					}
				}
				$operators[] = $operator;
				
				$columns = self::addTableToValues($table, $columns);
				
				if (sizeof($operators) == 1) {
					
					// Handle fuzzy searches
					if ($operator == '~') {
					
						// If the value to search is a single string value, parse it for search terms
						if (sizeof($values) == 1 && is_string($values[0])) {
							$values = self::parseSearchTerms($values[0], TRUE);	
						}
						
						$condition = array();
						foreach ($values as $value) {
							$sub_condition = array();
							foreach ($columns as $column) {
								$sub_condition[] = $column . self::retrieve()->escape(' LIKE %s', '%' . $value . '%');
							}
							$condition[] = '(' . join(' OR ', $sub_condition) . ')';
						}
						$sql[] = ' (' . join(' AND ', $condition) . ') ';
					
					// Handle intersection
					} elseif ($operator == '><') {
						
						if (sizeof($columns) != 2 || sizeof($values) != 2) {
							throw new fProgrammerException(
								'The intersection operator, %s, requires exactly two columns and two values',
								$operator
							);	
						}
															 
						if ($values[1] === NULL) {
							$part_1 = '(' . $columns[1] . ' IS NULL AND ' . $columns[0] . ' = ' . self::escapeBySchema($table, $columns[0], $values[0]) . ')';
							$part_2 = '(' . $columns[1] . ' IS NOT NULL AND ' . $columns[0] . ' <= ' . self::escapeBySchema($table, $columns[0], $values[0]) . ' AND ' . $columns[1] . ' >= ' . self::escapeBySchema($table, $columns[1], $values[0]) . ')';
						} else {
							$part_1 = '(' . $columns[0] . ' <= ' . self::escapeBySchema($table, $columns[0], $values[0]) . ' AND ' . $columns[1] . ' >= ' . self::escapeBySchema($table, $columns[1], $values[0]) . ')';
							$part_2 = '(' . $columns[0] . ' >= ' . self::escapeBySchema($table, $columns[0], $values[0]) . ' AND ' . $columns[0] . ' <= ' . self::escapeBySchema($table, $columns[0], $values[1]) . ')';
						}
						
						$sql[] = ' (' . $part_1 . ' OR ' . $part_2 . ') ';
					
					} else {
						throw new fProgrammerException(
							'An invalid comparison operator, %s, was specified for multiple columns',
							$operator
						);
					}
				
				// Handle OR combos
				} else {
					if (sizeof($columns) != sizeof($values)) {
						throw new fProgrammerException(
							'When creating an %1$s where clause there must be an equal number of columns and values, however there are not',
							'OR',
							sizeof($columns),
							sizeof($values)
						);
					}
					
					if (sizeof($columns) != sizeof($operators)) {
						throw new fProgrammerException(
							'When creating an %s where clause there must be a comparison operator for each column, however one or more is missing',
							'OR'
						);
					}
					
					$conditions = array();
					$iterations = sizeof($columns);
					for ($i=0; $i<$iterations; $i++) {
						$conditions[] = self::createColumnCondition($table, $columns[$i], $values[$i], $operators[$i]);
					}
					$sql[] = ' (' . join(' OR ', $conditions) . ') ';
				}

				
			// Single column condition
			} else {
				
				$columns = self::addTableToValues($table, array($column));
				$column  = $columns[0];
				
				$sql[] = self::createColumnCondition($table, $column, $values, $operator);
				
			}
		}
		
		return join(' AND ', $sql);
	}
	
	
	/**
	 * Escapes a value for a DB call based on database schema
	 * 
	 * @internal
	 * 
	 * @param  string $table                The table to store the value
	 * @param  string $column               The column to store the value in, may also be shorthand column name like `table.column` or `table=>related_table.column` or concatenated column names like `table.column||table.other_column`
	 * @param  mixed  $value                The value to escape
	 * @param  string $comparison_operator  Optional: should be `'='`, `'!='`, `'!'`, `'<>'`, `'<'`, `'<='`, `'>'`, `'>='`, `'IN'`, `'NOT IN'`
	 * @return string  The SQL-ready representation of the value
	 */
	static public function escapeBySchema($table, $column, $value, $comparison_operator=NULL)
	{
		// handle concatenated column names
		if (preg_match('#\|\|#', $column)) {
			
			if (is_object($value) && is_callable(array($value, '__toString'))) {
				$value = $value->__toString();
			} elseif (is_object($value)) {
				$value = (string) $value;
			}
			
			$column_info = array(
				'not_null' => FALSE,
				'default'  => NULL,
				'type'     => 'varchar'
			);
			
		} else {
			
			// Handle shorthand column names like table.column and table=>related_table.column
			if (preg_match('#(\w+)(?:\{\w+\})?\.(\w+)$#D', $column, $match)) {
				$table  = $match[1];
				$column = $match[2];
			}
			
			$column_info = fORMSchema::retrieve()->getColumnInfo($table, $column);	
			
			// Some of the tables being escaped for are linking tables that might break with classize()
			if (is_object($value)) {
				$class = fORM::classize($table);
				$value = fORM::scalarize($class, $column, $value);
			}
		
		}
		
		if ($comparison_operator !== NULL) {
			$comparison_operator = strtr($comparison_operator, array('!' => '<>', '!=' => '<>'));
		}
		
		$valid_comparison_operators = array('=', '!=', '!', '<>', '<=', '<', '>=', '>', 'IN', 'NOT IN');
		if ($comparison_operator !== NULL && !in_array(strtoupper($comparison_operator), $valid_comparison_operators)) {
			throw new fProgrammerException(
				'The comparison operator specified, %1$s, is invalid. Must be one of: %2$s.',
				$comparison_operator,
				join(', ', $valid_comparison_operators)
			);
		}
		
		$co = (is_null($comparison_operator)) ? '' : ' ' . strtoupper($comparison_operator) . ' ';
		
		if ($column_info['not_null'] && $value === NULL && $column_info['default'] !== NULL) {
			$value = $column_info['default'];
		}
		
		if (is_null($value)) {
			$prepared_value = 'NULL';
		} else {
			$prepared_value = self::retrieve()->escape($column_info['type'], $value);
		}
		
		if ($prepared_value == 'NULL') {
			if ($co) {
				if (in_array(trim($co), array('=', 'IN'))) {
					$co = ' IS ';
				} elseif (in_array(trim($co), array('<>', 'NOT IN'))) {
					$co = ' IS NOT ';
				}
			}
		}
		
		return $co . $prepared_value;
	}
	
	
	/**
	 * Escapes a value for a DB call based on variable type
	 *
	 * @internal
	 *
	 * @param  mixed  $value                The value to escape
	 * @param  string $comparison_operator  Optional: should be `'='`, `'!='`, `'!'`, `'<>'`, `'<'`, `'<='`, `'>'`, `'>='`, `'IN'`, `'NOT IN'`
	 * @return string  The SQL-ready representation of the value
	 */
	static public function escapeByType($value, $comparison_operator=NULL)
	{
		if ($comparison_operator !== NULL) {
			$comparison_operator = strtr($comparison_operator, array('!' => '<>', '!=' => '<>'));
		}
		
		$valid_comparison_operators = array('=', '<>', '<=', '<', '>=', '>', 'IN', 'NOT IN');
		if ($comparison_operator !== NULL && !in_array(strtoupper($comparison_operator), $valid_comparison_operators)) {
			throw new fProgrammerException(
				'The comparison operator specified, %1$s, is invalid. Must be one of: %2$s.',
				$comparison_operator,
				join(', ', $valid_comparison_operators)
			);
		}
		
		$co = (is_null($comparison_operator)) ? '' : ' ' . strtoupper($comparison_operator) . ' ';
		
		if (is_int($value)) {
			$prepared_value = self::retrieve()->escape('integer', $value);
		} elseif (is_float($value)) {
			$prepared_value = self::retrieve()->escape('float', $value);
		} elseif (is_bool($value)) {
			$prepared_value = self::retrieve()->escape('boolean', $value);
		} elseif (is_null($value)) {
			if ($co) {
				if (in_array(trim($co), array('=', 'IN'))) {
					$co = ' IS ';
				} elseif (in_array(trim($co), array('<>', 'NOT IN'))) {
					$co = ' IS NOT ';
				}
			}
			$prepared_value = 'NULL';
		} else {
			$prepared_value = self::retrieve()->escape('string', $value);
		}
		
		return $co . $prepared_value;
	}
	
	
	/**
	 * Finds all of the table names in the SQL and creates the appropriate `FROM` and `GROUP BY` clauses with all necessary joins
	 * 
	 * The SQL string should contain two placeholders, `:from_clause` and
	 * `:group_by_clause`. All columns should be qualified with their full table
	 * name. Here is an example SQL string to pass in presumming that the
	 * tables users and groups are in a relationship:
	 * 
	 * {{{
	 * SELECT users.* FROM :from_clause WHERE groups.group_id = 5 :group_by_clause ORDER BY lower(users.first_name) ASC
	 * }}}
	 * 
	 * @internal
	 * 
	 * @param  string $table  The main table to be queried
	 * @param  string $sql    The SQL to insert the `FROM` clause into
	 * @return string  The SQL `FROM` clause
	 */
	static public function insertFromAndGroupByClauses($table, $sql)
	{
		$joins = array();
		
		if (strpos($sql, ':from_clause') === FALSE) {
			throw new fProgrammerException(
				"No %1\$s placeholder was found in:%2\$s",
				':from_clause',
				"\n" . $sql
			);
		}
		
		if (strpos($sql, ':group_by_clause') === FALSE && !preg_match('#group\s+by#i', $sql)) {
			throw new fProgrammerException(
				"No %1\$s placeholder was found in:%2\$s",
				':group_by_clause',
				"\n" . $sql
			);
		}
		
		$has_group_by_placeholder = (strpos($sql, ':group_by_clause') !== FALSE) ? TRUE : FALSE;
		
		// Separate the SQL from quoted values
		preg_match_all("#(?:'(?:''|\\\\'|\\\\[^']|[^'\\\\])*')|(?:[^']+)#", $sql, $matches);
		
		$table_alias = $table;
		
		$used_aliases  = array();
		$table_map     = array();
		
		// If we are not passing in existing joins, start with the specified table
		if (!$joins) {
			$joins[] = array(
				'join_type'   => 'none',
				'table_name'  => $table,
				'table_alias' => $table_alias
			);
		}
		
		$used_aliases[] = $table_alias;
		
		foreach ($matches[0] as $match) {
			if ($match[0] != "'") {
				preg_match_all('#\b((?:(\w+)(?:\{(\w+)\})?=>)?(\w+)(?:\{(\w+)\})?)\.\w+\b#m', $match, $table_matches, PREG_SET_ORDER);
				foreach ($table_matches as $table_match) {
					
					if (!isset($table_match[5])) {
						$table_match[5] = NULL;
					}
					
					// This is a related table that is going to join to a once-removed table
					if (!empty($table_match[2])) {
						
						$related_table = $table_match[2];
						$route = fORMSchema::getRouteName($table, $related_table, $table_match[3]);
						
						$join_name = $table . '_' . $related_table . '{' . $route . '}';
						
						self::createJoin($table, $table_alias, $related_table, $route, $joins, $used_aliases);
						
						$once_removed_table = $table_match[4];
						$route = fORMSchema::getRouteName($related_table, $once_removed_table, $table_match[5]);
						
						$join_name = self::createJoin($related_table, $joins[$join_name]['table_alias'], $once_removed_table, $route, $joins, $used_aliases);
						
						$table_map[$table_match[1]] = $joins[$join_name]['table_alias'];
					
					// This is a related table
					} elseif (($table_match[4] != $table || fORMSchema::getRoutes($table, $table_match[4])) && $table_match[1] != $table) {
					
						$related_table = $table_match[4];
						$route = fORMSchema::getRouteName($table, $related_table, $table_match[5]);
						
						// If the related table is the current table and it is a one-to-many we don't want to join
						if ($table_match[4] == $table) {
							$one_to_many_routes = fORMSchema::getRoutes($table, $related_table, 'one-to-many');
							if (isset($one_to_many_routes[$route])) {
								$table_map[$table_match[1]] = $table_alias;
								continue;
							}
						}
						
						$join_name = self::createJoin($table, $table_alias, $related_table, $route, $joins, $used_aliases);
						
						$table_map[$table_match[1]] = $joins[$join_name]['table_alias'];
					}
				}
			}
		}
		
		// Determine if we joined a *-to-many relationship
		$joined_to_many = FALSE;
		foreach ($joins as $name => $join) {
			if (is_numeric($name)) {
				continue;
			}
			
			if (substr($name, -5) == '_join') {
				$joined_to_many = TRUE;
				break;
			}
			
			$main_table   = preg_replace('#_' . $join['table_name'] . '{\w+}$#iD', '', $name);
			$second_table = $join['table_name'];
			$route        = preg_replace('#^[^{]+{(\w+)}$#D', '\1', $name);
			$routes       = fORMSchema::getRoutes($main_table, $second_table, '*-to-many');
			if (isset($routes[$route])) {
				$joined_to_many = TRUE;
				break;
			}
		}
		$found_order_by = FALSE;
		
		$from_clause     = self::createFromClauseFromJoins($joins);
		
		// If we are joining on a *-to-many relationship we need to group by the
		// columns in the main table to prevent duplicate entries
		if ($joined_to_many) {
			$column_info     = fORMSchema::retrieve()->getColumnInfo($table);
			$group_by_clause = ' GROUP BY ';
			$columns         = array();
			foreach ($column_info as $column => $info) {
				$columns[] = $table . '.' . $column;
			}
			$group_by_columns = join(', ', $columns) . ' ';
			$group_by_clause .= $group_by_columns;
		} else {
			$group_by_clause = ' ';
			$group_by_columns = '';
		}
		
		// Put the SQL back together
		$new_sql = '';
		foreach ($matches[0] as $match) {
			$temp_sql = $match;
			
			// Get rid of the => notation and the :from_clause placeholder
			if ($match[0] !== "'") {
				foreach ($table_map as $arrow_table => $alias) {
					$temp_sql = str_replace($arrow_table, $alias, $temp_sql);
				}
				
				// In the ORDER BY clause we need to wrap columns in
				if ($found_order_by && $joined_to_many) {
					$temp_sql = preg_replace('#(?<!avg\(|count\(|max\(|min\(|sum\(|cast\(|case |when )\b((?!' . preg_quote($table, '#') . '\.)\w+\.\w+)\b#i', 'max(\1)', $temp_sql);
				}
				
				if ($joined_to_many && preg_match('#order\s+by#i', $temp_sql)) {
					$order_by_found = TRUE;
					
					$parts = preg_split('#(order\s+by)#i', $temp_sql, -1, PREG_SPLIT_DELIM_CAPTURE);
					$parts[2] = $temp_sql = preg_replace('#(?<!avg\(|count\(|max\(|min\(|sum\(|cast\(|case |when )\b((?!' . preg_quote($table, '#') . '\.)\w+\.\w+)\b#i', 'max(\1)', $parts[2]);
					
					$temp_sql = join('', $parts);
				}
				
				$temp_sql = str_replace(':from_clause', $from_clause, $temp_sql);
				if ($has_group_by_placeholder) {
					$temp_sql = preg_replace('#\s:group_by_clause\s#', strtr($group_by_clause, array('\\' => '\\\\', '$' => '\\$')), $temp_sql);
				} elseif ($group_by_columns) {
					$temp_sql = preg_replace('#(\sGROUP\s+BY\s((?!HAVING|ORDER\s+BY).)*)\s#i', '\1, ' . strtr($group_by_columns, array('\\' => '\\\\', '$' => '\\$')), $temp_sql);
				}
			}
			
			$new_sql .= $temp_sql;
		}
			
		return $new_sql;
	}
	
	
	/**
	 * Parses a search string into search terms, supports quoted phrases and removes extra punctuation
	 * 
	 * @internal
	 * 
	 * @param  string  $terms              A text string from a form input to parse into search terms
	 * @param  boolean $ignore_stop_words  If stop words should be ignored, this setting will be ignored if all words are stop words
	 * @return void
	 */
	static public function parseSearchTerms($terms, $ignore_stop_words=FALSE)
	{
		$stop_words = array(
			'i',     'a',     'an',    'are',   'as',    'at',    'be',    
			'by',    'de',    'en',    'en',    'for',   'from',  'how',   
			'in',    'is',    'it',    'la',    'of',    'on',    'or',    
			'that',  'the',   'this',  'to',    'was',   'what',  'when',  
			'where', 'who',   'will'
		);
		
		preg_match_all('#(?:"[^"]+"|[^\s]+)#', $terms, $matches);
		
		$good_terms    = array();
		$ignored_terms = array();
		foreach ($matches[0] as $match) {
			// Remove phrases from quotes
			if ($match[0] == '"' && substr($match, -1)) {
				$match = substr($match, 1, -1);	
			
			// Trim any punctuation off of the beginning and end of terms
			} else {
				$match = preg_replace('#(^[^a-z0-9]+|[^a-z0-9]+$)#iD', '', $match);	
			}
			
			if ($ignore_stop_words && in_array(strtolower($match), $stop_words)) {
				$ignored_terms[] = $match;
				continue;	
			}
			$good_terms[] = $match;
		}
		
		// If no terms were parsed, that means all words were stop words
		if ($ignored_terms && !$good_terms) {
			$good_terms = $ignored_terms;
		}	
		
		return $good_terms;
	}
	
	
	/**
	 * Removed aggregate function calls from where conditions array and puts them in a having conditions array
	 * 
	 * @internal
	 * 
	 * @param  array &$where_conditions  The where conditions to look through for aggregate functions
	 * @return array  The conditions to be put in a `HAVING` clause
	 */
	static public function splitHavingConditions(&$where_conditions)
	{
		$having_conditions    = array();
		
		foreach ($where_conditions as $column => $value)
		{
			if (preg_match('#^(count\(|max\(|avg\(|min\(|sum\()#i', $column)) {
				$having_conditions[$column] = $value;
				unset($where_conditions[$column]);
			}	
		}
		
		return $having_conditions;	
	}
	
	
	/**
	 * Resets the configuration of the class
	 * 
	 * @internal
	 * 
	 * @return void
	 */
	static public function reset()
	{
		self::$database_object = NULL;
	}
	
	
	/**
	 * Return the instance of the fDatabase class
	 * 
	 * @return fDatabase  The database instance
	 */
	static public function retrieve()
	{
		if (!self::$database_object) {
			throw new fProgrammerException(
				'The method %1$s needs to be called before %2$s',
				'attach()',
				'retrieve()'
			);
		}
		return self::$database_object;
	}
	
	
	/**
	 * Forces use as a static class
	 * 
	 * @return fORMDatabase
	 */
	private function __construct() { }
}



/**
 * Copyright (c) 2007-2009 Will Bond <will@flourishlib.com>, others
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */