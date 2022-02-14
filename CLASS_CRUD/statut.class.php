<?php
// CRUD STATUT
// ETUD
require_once __DIR__ . '../../CONNECT/database.php';

class STATUT{
	function get_1Statut($idStat){
		global $db;

		$query='SELECT * FROM STATUT WHERE idStat= ?';
		$request = $db->prepare($query);
		$request->execute([$idStat]);
		return($request->fetch());
	}

	function get_AllStatuts(){
		global $db;
		$query ='SELECT * FROM STATUT;';
		$result = $db->query($query);
		$allStatuts= $result->fetchAll();
		return($allStatuts);
	}

	function create($libStat){
		global $db;

		try {
			$db->beginTransaction();

			$query = 'INSERT INTO STATUT(libStat) VALUES (?)';
			$request = $db->prepare($query);
			$request->execute([$libStat]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur insert STATUT : ' . $e->getMessage());
		}
	}

	function update($idStat, $libStat){
		global $db;

		try {
			$db->beginTransaction();

			$query='UPDATE STATUT SET libStat=? WHERE idStat=?';
			$request = $db->prepare($query);
			$request->execute([$libStat, $idStat]);
			$db->commit();
			$request->closeCursor();
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur update STATUT : ' . $e->getMessage());
		}
	}

	function delete($idStat){
		global $db;
		
		try {
			$db->beginTransaction();

			$query='DELETE FROM STATUT WHERE idStat=?';
			$request = $db->prepare($query);
			$request->execute([$idStat]);
			$count = $request->rowCount(); //
			$db->commit();
			$request->closeCursor();
			return($count); //
		}
		catch (PDOException $e) {
			$db->rollBack();
			$request->closeCursor();
			die('Erreur delete STATUT : ' . $e->getMessage());
		}
	}
}	// End of class
