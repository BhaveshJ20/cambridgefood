<?php

function wp_all_export_comments_clauses($obj){
	
	// cron job execution
	if ( empty(PMXE_Plugin::$session)) 
	{
		$id = $_GET['export_id'];
		$export = new PMXE_Export_Record();
		$export->getById($id);	
		if ( ! $export->isEmpty() ){		
			if ( ! empty($export->options['whereclause']) ) $obj['where'] .= $export->options['whereclause'];
			if ( ! empty($export->options['joinclause']) ) {
				$obj['join'] .= implode( ' ', array_unique( $export->options['joinclause'] ) );		
			}
		}
	}
	else
	{	
		$customWhere = PMXE_Plugin::$session->get('whereclause');		
		$obj['where'] .= $customWhere;

		$customJoin = PMXE_Plugin::$session->get('joinclause');

		if ( ! empty( $customJoin ) ) {		
			$obj['join'] .= implode( ' ', array_unique( $customJoin ) );	
		}
	}

	return $obj;
}