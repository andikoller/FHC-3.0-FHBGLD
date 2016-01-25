<?php
/* Copyright (C) 2007 Technikum-Wien
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
 *
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>,
 *          Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at> and
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at>.
 */
/**
 * Klasse projektarbeit
 * @create 08-02-2007
 */
require_once(dirname(__FILE__).'/basis_db.class.php');

class projektarbeit extends basis_db
{
	public $new;       		// boolean
	public $result = array(); 	// adresse Objekt

	//Tabellenspalten
	public $projektarbeit_id;	// integer
	public $projekttyp_kurzbz;	// string
	public $bezeichnung;		// string
	public $titel;				// string
	public $titel_english;		// string
	public $lehreinheit_id;		// integer
	public $student_uid;		// integer
	public $firma_id;			// integer
	public $note;				// integer
	public $punkte;				// numeric(6,2)
	public $beginn;				// date
	public $ende;				// date
	public $faktor;				// numeric(3,2)
	public $freigegeben;		// boolean
	public $gesperrtbis;		// date
	public $stundensatz;		// numeric(6,2)
	public $gesamtstunden;		// numeric(8,2)
	public $themenbereich;		// sting
	public $anmerkung;			// string
	public $ext_id;				// integer
	public $insertamum;			// timestamp
	public $insertvon;			// bigint
	public $updateamum;			// timestamp
	public $updatevon;			// bigint


	/**
	 * Konstruktor
	 * @param $projektarbeit_id ID der Projektarbeit, die geladen werden soll (Default=null)
	 */
	public function __construct($projektarbeit_id=null)
	{
		parent::__construct();

<<<<<<< HEAD
		if($projektarbeit_id != null) 	
=======
		if($projektarbeit_id != null)
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$this->load($projektarbeit_id);
	}

	/**
	 * Laedt die Projektarbeit mit der ID $projektarbeit_id
	 * @param  $projektarbeit_id ID der zu ladenden Projektarbeit
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function load($projektarbeit_id)
	{
		if(!is_numeric($projektarbeit_id))
		{
			$this->errormsg = 'Projektarbeit_id muss eine gueltige Zahl sein';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT * FROM lehre.tbl_projektarbeit WHERE projektarbeit_id=".$this->db_add_param($projektarbeit_id, FHC_INTEGER);
		
=======

		$qry = "SELECT * FROM lehre.tbl_projektarbeit "
			. "JOIN lehre.tbl_projekttyp USING (projekttyp_kurzbz) "
			. "WHERE projektarbeit_id=".$this->db_add_param($projektarbeit_id, FHC_INTEGER);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$this->projektarbeit_id = $row->projektarbeit_id;
				$this->projekttyp_kurzbz = $row->projekttyp_kurzbz;
				$this->titel = $row->titel;
				$this->titel_english = $row->titel_english;
				$this->lehreinheit_id = $row->lehreinheit_id;
				$this->student_uid = $row->student_uid;
				$this->firma_id = $row->firma_id;
				$this->note = $row->note;
				$this->punkte = $row->punkte;
				$this->beginn = $row->beginn;
				$this->ende = $row->ende;
				$this->faktor = $row->faktor;
				$this->freigegeben = $this->db_parse_bool($row->freigegeben);
				$this->gesperrtbis = $row->gesperrtbis;
				$this->stundensatz = $row->stundensatz;
				$this->gesamtstunden = $row->gesamtstunden;
				$this->themenbereich = $row->themenbereich;
				$this->anmerkung = $row->anmerkung;
				$this->ext_id = $row->ext_id;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
<<<<<<< HEAD
				return true;
			}
			else 
=======
				$this->projekttyp_bezeichnung = $row->bezeichnung;
				return true;
			}
			else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			{
				$this->errormsg = 'Datensatz wurde nicht gefunden';
				return false;
			}
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}

	/**
	 * Prueft die Variablen auf Gueltigkeit
	 * @return true wenn ok, false im Fehlerfall
	 */
	protected function validate()
	{

		//Gesamtlaenge pruefen
		if ($this->projekttyp_kurzbz==null)
		{
			$this->errormsg='Projekttyp_kurzbz darf nicht NULL sein!';
		}
		if ($this->lehreinheit_id==null)
		{
			$this->errormsg='Lehreinheit_id darf nicht NULL sein!';
		}
		if(mb_strlen($this->projekttyp_kurzbz)>16)
		{
			$this->errormsg = 'Projektyp_kurzbz darf nicht länger als 16 Zeichen sein';
			return false;
		}
		if(mb_strlen($this->titel)>1024)
		{
			$this->errormsg = 'Titel darf nicht länger als 1024 Zeichen sein';
			return false;
		}
		if(mb_strlen($this->titel_english)>1024)
		{
			$this->errormsg = 'Titel darf nicht länger als 1024 Zeichen sein';
			return false;
		}
		if(mb_strlen($this->themenbereich)>64)
		{
			$this->errormsg = 'Themenbereich darf nicht länger als 64 Zeichen sein';
			return false;
		}
		if(mb_strlen($this->anmerkung)>256)
		{
			$this->errormsg = 'Anmerkung darf nicht länger als 256 Zeichen sein';
			return false;
		}
		/*if(!is_numeric($this->note))
		{
			$this->errormsg = 'Note muß ein numerischer Wert sein - student_uid: '.$this->student_uid;
			return false;
		}*/
		if($this->punkte!='' && !is_numeric($this->punkte))
		{
			$this->errormsg = 'Punkte muss ein numerischer Wert sein';
			return false;
		}
		if($this->faktor!='' && !is_numeric($this->faktor))
		{
			$this->errormsg = 'Faktor muss ein numerischer Wert sein';
			return false;
		}
		if($this->stundensatz!='' && !is_numeric($this->stundensatz))
		{
			$this->errormsg = 'Stundensatz muss ein numerischer Wert sein';
			return false;
		}
		if($this->gesamtstunden!='' && !is_numeric($this->gesamtstunden))
		{
			$this->errormsg = 'Gesamtstunden muss ein numerischer Wert sein';
			return false;
		}
		if(!is_bool($this->freigegeben))
		{
			$this->errormsg = 'freigegeben ist ungueltig';
			return false;
		}

		$this->errormsg = '';
		return true;
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Speichert den aktuellen Datensatz in die Datenbank
	 * Wenn $neu auf true gesetzt ist wird ein neuer Datensatz angelegt
	 * andernfalls wird der Datensatz mit der ID in $projektarbeit_id aktualisiert
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function save($new=null)
	{
		//Variablen pruefen
		if(!$this->validate())
			return false;

		if($new==null)
			$new = $this->new;
<<<<<<< HEAD
			
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($new)
		{
			//Neuen Datensatz einfuegen

<<<<<<< HEAD
			$qry='BEGIN; INSERT INTO lehre.tbl_projektarbeit (projekttyp_kurzbz, titel, lehreinheit_id, student_uid, firma_id, note, punkte, 
				beginn, ende, faktor, freigegeben, gesperrtbis, stundensatz, gesamtstunden, themenbereich, anmerkung, 
				ext_id, insertamum, insertvon, updateamum, updatevon, titel_english) VALUES('.
=======
			$qry='BEGIN; INSERT INTO lehre.tbl_projektarbeit (projekttyp_kurzbz, titel, lehreinheit_id, student_uid, firma_id, note, punkte,
				beginn, ende, faktor, freigegeben, gesperrtbis, stundensatz, gesamtstunden, themenbereich, anmerkung,
				insertamum, insertvon, updateamum, updatevon, titel_english) VALUES('.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			     $this->db_add_param($this->projekttyp_kurzbz).', '.
			     $this->db_add_param($this->titel).', '.
			     $this->db_add_param($this->lehreinheit_id, FHC_INTEGER).', '.
			     $this->db_add_param($this->student_uid).', '.
			     $this->db_add_param($this->firma_id, FHC_INTEGER).', '.
			     $this->db_add_param($this->note).', '.
			     $this->db_add_param($this->punkte).', '.
			     $this->db_add_param($this->beginn).', '.
			     $this->db_add_param($this->ende).', '.
			     $this->db_add_param($this->faktor).', '.
			     $this->db_add_param($this->freigegeben, FHC_BOOLEAN).', '.
			     $this->db_add_param($this->gesperrtbis).', '.
			     $this->db_add_param($this->stundensatz).', '.
			     $this->db_add_param($this->gesamtstunden).', '.
			     $this->db_add_param($this->themenbereich).', '.
<<<<<<< HEAD
			     $this->db_add_param($this->anmerkung).', '.
			     $this->db_add_param($this->ext_id).',  now(), '.
=======
			     $this->db_add_param($this->anmerkung).', now(), '.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			     $this->db_add_param($this->insertvon).', now(), '.
			     $this->db_add_param($this->updatevon).','.
			     $this->db_add_param($this->titel_english).');';
		}
		else
		{
			//Updaten des bestehenden Datensatzes

			//Pruefen ob projektarbeit_id eine gueltige Zahl ist
			if(!is_numeric($this->projektarbeit_id))
			{
				$this->errormsg = 'projektarbeit_id muss eine gueltige Zahl sein';
				return false;
			}

			$qry='UPDATE lehre.tbl_projektarbeit SET '.
				'projekttyp_kurzbz='.$this->db_add_param($this->projekttyp_kurzbz).', '.
				'titel='.$this->db_add_param($this->titel).', '.
				'titel_english='.$this->db_add_param($this->titel_english).', '.
				'lehreinheit_id='.$this->db_add_param($this->lehreinheit_id, FHC_INTEGER).', '.
				'student_uid='.$this->db_add_param($this->student_uid).', '.
				'firma_id='.$this->db_add_param($this->firma_id, FHC_INTEGER).', '.
				'note='.$this->db_add_param($this->note).', '.
				'punkte='.$this->db_add_param($this->punkte).', '.
				'beginn='.$this->db_add_param($this->beginn).', '.
				'ende='.$this->db_add_param($this->ende).', '.
				'faktor='.$this->db_add_param($this->faktor).', '.
				'freigegeben='.$this->db_add_param($this->freigegeben, FHC_BOOLEAN).', '.
				'gesperrtbis='.$this->db_add_param($this->gesperrtbis).', '.
				'stundensatz='.$this->db_add_param($this->stundensatz).', '.
				'gesamtstunden='.$this->db_add_param($this->gesamtstunden).', '.
				'themenbereich='.$this->db_add_param($this->themenbereich).', '.
				'anmerkung='.$this->db_add_param($this->anmerkung).', '.
				'updateamum= now(), '.
				'updatevon='.$this->db_add_param($this->updatevon).' '.
				'WHERE projektarbeit_id='.$this->db_add_param($this->projektarbeit_id, FHC_INTEGER).';';
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			if($new)
			{
				//Sequence auslesen
				$qry = "SELECT currval('lehre.tbl_projektarbeit_projektarbeit_id_seq') as id;";
				if($this->db_query($qry))
				{
					if($row = $this->db_fetch_object())
					{
						$this->projektarbeit_id = $row->id;
						$this->db_query('COMMIT');
						return true;
					}
<<<<<<< HEAD
					else 
=======
					else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					{
						$this->errormsg = 'Fehler beim Auslesen der Sequence';
						$this->db_query('ROLLBACK;');
						return false;
					}
				}
<<<<<<< HEAD
				else 
=======
				else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				{
					$this->errormsg = 'Fehler beim Auslesen der Sequence';
					$this->db_query('ROLLBACK;');
					return false;
				}
			}
<<<<<<< HEAD
					
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Speichern der Daten';
			return false;
		}
	}

	/**
	 * Loescht den Datenensatz mit der ID die uebergeben wird
	 * @param $projektarbeit_id ID die geloescht werden soll
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function delete($projektarbeit_id)
	{
		if(!is_numeric($projektarbeit_id))
		{
			$this->errormsg = 'Projektarbeit_id ist ungueltig';
			return true;
		}
<<<<<<< HEAD
		
		$qry = "DELETE FROM lehre.tbl_projektarbeit WHERE projektarbeit_id=".$this->db_add_param($projektarbeit_id, FHC_INTEGER);
		
=======

		$qry = "DELETE FROM lehre.tbl_projektarbeit WHERE projektarbeit_id=".$this->db_add_param($projektarbeit_id, FHC_INTEGER);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			return true;
		}
<<<<<<< HEAD
		else 
		{
			$this->errormsg = 'Fehler beim Loeschen des Datensatzes';
			return false;
		}		
	}
	
=======
		else
		{
			$this->errormsg = 'Fehler beim Loeschen des Datensatzes';
			return false;
		}
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt alle Projektarbeiten eines Studenten
	 * @param student_uid
	 * @return true wenn ok, false wenn Fehler
	 */
	public function getProjektarbeit($student_uid)
	{
<<<<<<< HEAD
		$qry = "SELECT * FROM lehre.tbl_projektarbeit JOIN lehre.tbl_projekttyp USING (projekttyp_kurzbz) 
				WHERE student_uid=".$this->db_add_param($student_uid);
		
=======
		$qry = "SELECT * FROM lehre.tbl_projektarbeit JOIN lehre.tbl_projekttyp USING (projekttyp_kurzbz)
				WHERE student_uid=".$this->db_add_param($student_uid);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$obj = new projektarbeit();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$obj->projektarbeit_id = $row->projektarbeit_id;
				$obj->projekttyp_kurzbz = $row->projekttyp_kurzbz;
				$obj->bezeichnung = $row->bezeichnung;
				$obj->titel = $row->titel;
				$obj->titel_english = $row->titel_english;
				$obj->lehreinheit_id = $row->lehreinheit_id;
				$obj->student_uid = $row->student_uid;
				$obj->firma_id = $row->firma_id;
				$obj->note = $row->note;
				$obj->punkte = $row->punkte;
				$obj->beginn = $row->beginn;
				$obj->ende = $row->ende;
				$obj->faktor = $row->faktor;
				$obj->freigegeben = $this->db_parse_bool($row->freigegeben);
				$obj->gesperrtbis = $row->gesperrtbis;
				$obj->stundensatz = $row->stundensatz;
				$obj->gesamtstunden = $row->gesamtstunden;
				$obj->themenbereich = $row->themenbereich;
				$obj->anmerkung = $row->anmerkung;
				$obj->ext_id = $row->ext_id;
				$obj->insertamum = $row->insertamum;
				$obj->insertvon = $row->insertvon;
				$obj->updateamum = $row->updateamum;
				$obj->updatevon = $row->updatevon;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->result[] = $obj;
			}
			return true;
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt alle Projektarbeiten eines Studienganges/Studiensemesters
	 * @param studiengang_kz, studiensemester_kurzbz
	 * @return true wenn ok, false wenn Fehler
	 */
	public function getProjektarbeitStudiensemester($studiengang_kz, $studiensemester_kurzbz)
	{
<<<<<<< HEAD
		$qry = "SELECT 
					tbl_projektarbeit.* , tbl_projekttyp.bezeichnung 
				FROM 
					lehre.tbl_projektarbeit
				JOIN
					lehre.tbl_projekttyp USING (projekttyp_kurzbz), lehre.tbl_lehreinheit, lehre.tbl_lehrveranstaltung
				 
				WHERE 
=======
		$qry = "SELECT
					tbl_projektarbeit.* , tbl_projekttyp.bezeichnung
				FROM
					lehre.tbl_projektarbeit
				JOIN
					lehre.tbl_projekttyp USING (projekttyp_kurzbz), lehre.tbl_lehreinheit, lehre.tbl_lehrveranstaltung

				WHERE
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					tbl_projektarbeit.lehreinheit_id=tbl_lehreinheit.lehreinheit_id AND
					tbl_lehreinheit.lehrveranstaltung_id = tbl_lehrveranstaltung.lehrveranstaltung_id AND
					tbl_lehrveranstaltung.studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER)." AND
					tbl_lehreinheit.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$obj = new projektarbeit();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$obj->projektarbeit_id = $row->projektarbeit_id;
				$obj->projekttyp_kurzbz = $row->projekttyp_kurzbz;
				$obj->bezeichnung = $row->bezeichnung;
				$obj->titel = $row->titel;
				$obj->titel_english = $row->titel_english;
				$obj->lehreinheit_id = $row->lehreinheit_id;
				$obj->student_uid = $row->student_uid;
				$obj->firma_id = $row->firma_id;
				$obj->note = $row->note;
				$obj->punkte = $row->punkte;
				$obj->beginn = $row->beginn;
				$obj->ende = $row->ende;
				$obj->faktor = $row->faktor;
				$obj->freigegeben = $this->db_parse_bool($row->freigegeben);
				$obj->gesperrtbis = $row->gesperrtbis;
				$obj->stundensatz = $row->stundensatz;
				$obj->gesamtstunden = $row->gesamtstunden;
				$obj->themenbereich = $row->themenbereich;
				$obj->anmerkung = $row->anmerkung;
				$obj->ext_id = $row->ext_id;
				$obj->insertamum = $row->insertamum;
				$obj->insertvon = $row->insertvon;
				$obj->updateamum = $row->updateamum;
				$obj->updatevon = $row->updatevon;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->result[] = $obj;
			}
			return true;
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
}
?>