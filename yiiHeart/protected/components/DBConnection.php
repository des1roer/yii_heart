<?php
/**
 * Database connection
 */
class DBConnection extends CDbConnection {

	public $defaultSchema = null;

	protected function initConnection($pdo) {
		parent::initConnection($pdo);

		if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) == 'pgsql') {
			$this->driverMap['pgsql']='PgsqlSchema';
			if (!is_null($this->defaultSchema)) {
				Yii::trace("PostgreSQL: changing schema to '{$this->defaultSchema}'", 'protected.components.DbConnection');
				$cmd = $pdo->prepare("SET search_path TO '{$this->defaultSchema}'");
				$cmd->execute();
			}
		}
	}
}
