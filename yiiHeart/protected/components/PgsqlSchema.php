<?php

/**
 * Class PgsqlSchema allows read tables definitions from PostgreSQL
 */
class PgsqlSchema extends CPgsqlSchema
{

    private $_defaultSchema = 'public';
    private $_sequences = array();

    function __construct($conn)
    {
        parent::__construct($conn);
        $this->_defaultSchema = $conn->defaultSchema;
    }

    protected function resolveTableNames($table, $name)
    {
        $parts = explode('.', str_replace('"', '', $name));
        if (isset($parts[1]))
        {
            $schemaName = $parts[0];
            $tableName = $parts[1];
        }
        else
        {
            $schemaName = $this->_defaultSchema;
            $tableName = $parts[0];
        }

        $table->name = $tableName;
        $table->schemaName = $schemaName;
        if ($schemaName === $this->_defaultSchema)
        {
            $table->rawName = $this->quoteTableName($tableName);
        }
        else
        {
            $table->rawName = $this->quoteTableName($schemaName) . '.' . $this->quoteTableName($tableName);
        }
    }

    protected function findColumns($table)
    {
        $sql = <<<EOD
SELECT a.attname, LOWER(format_type(a.atttypid, a.atttypmod)) AS type, d.adsrc, a.attnotnull, a.atthasdef, pg_catalog.col_description(a.attrelid, a.attnum) AS comment
FROM pg_attribute a LEFT JOIN pg_attrdef d ON a.attrelid = d.adrelid AND a.attnum = d.adnum
WHERE a.attnum > 0 AND NOT a.attisdropped
AND a.attrelid = (SELECT oid FROM pg_catalog.pg_class WHERE relname = :table
AND relnamespace = (SELECT oid FROM pg_catalog.pg_namespace WHERE nspname = :schema))
ORDER BY a.attnum
EOD;
        $command = $this->getDbConnection()->createCommand($sql);
        $command->bindValue(':table', $table->name);
        $command->bindValue(':schema', $table->schemaName);

        if (($columns = $command->queryAll()) === array())
        {
            return false;
        }

        foreach ($columns as $column)
        {
            $c = $this->createColumn($column);
            $table->columns[$c->name] = $c;

            if (stripos($column['adsrc'], 'nextval') === 0 && preg_match('/nextval\([^\']*\'([^\']+)\'[^\)]*\)/i', $column['adsrc'], $matches))
            {

                if (strpos($matches[1], '.') !== false || $table->schemaName === $this->_defaultSchema)
                {
                    $this->_sequences[$table->rawName . '.' . $c->name] = $matches[1];
                }
                else
                {
                    $this->_sequences[$table->rawName . '.' . $c->name] = $table->schemaName . '.' . $matches[1];
                }
                $c->autoIncrement = true;
            }
        }
        return true;
    }

    protected function findTableNames($schema = '')
    {
        if ($schema === '')
        {
            $schema = $this->_defaultSchema;
        }

        $sql = <<<EOD
SELECT table_name, table_schema FROM information_schema.tables
WHERE table_schema = :schema AND table_type = 'BASE TABLE'
EOD;
        $command = $this->getDbConnection()->createCommand($sql);
        $command->bindParam(':schema', $schema);
        $rows = $command->queryAll();
        $names = array();
        foreach ($rows as $row)
        {
            if ($schema === $this->_defaultSchema)
            {
                $names[] = $row['table_name'];
            }
            else
            {
                $names[] = $row['table_schema'] . '.' . $row['table_name'];
            }
        }
        return $names;
    }

}
