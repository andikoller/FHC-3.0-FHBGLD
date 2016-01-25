<?php
/* Copyright (C) 2009 Technikum-Wien
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
 *          Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at>,
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at> and
 *			Gerald Simane-Sequens <gerald.simane-sequens@technikum-wien.at>
 */
require_once('basis_db.class.php');

<<<<<<< HEAD
class variable extends basis_db 
=======
class variable extends basis_db
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
{
	public $errormsg; // string
	public $new;      // boolean
	public $variables = array(); // variable Objekt
	public $variable;

	//Tabellenspalten
	public $uid;	// varchar(32)
	public $name;	// varchar(64)
	public $wert;	// varchar(64)

	/**
	 * Konstruktor - Laedt optional eine Variable
	 * @param $uid
	 * @param $name
	 */
	public function __construct($uid=null, $name=null)
	{
		parent::__construct();
		$this->variable= new stdClass();
		if($uid!=null && $name!=null)
			$this->load($uid, $name);
	}

	/**
	 * Laedt eine Variable
	 * @param $uid
	 * @param $name
	 */
	public function load($uid, $name)
	{
		$qry = "SELECT wert FROM public.tbl_variable WHERE uid=".$this->db_add_param($uid)." AND name=".$this->db_add_param($name);
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$this->uid = $uid;
				$this->name = $name;
				$this->wert = $row->wert;
<<<<<<< HEAD
				
				return true;
			}
			else 
=======

				return true;
			}
			else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				return false;
		}
		else
			return false;
	}

	/**
	 * Prueft die Variablen vor dem Speichern
	 * auf Gueltigkeit.
	 * @return true wenn ok, false im Fehlerfall
	 */
	protected function validate()
	{
		if(mb_strlen($this->uid)>32)
		{
			$this->errormsg = 'UID darf nicht laenger als 32 Zeichen sein';
			return true;
		}
		if(mb_strlen($this->name)>64)
		{
			$this->errormsg = 'Name darf nicht laenger als 64 Zeichen sein';
			return false;
		}
		if(mb_strlen($this->wert)>64)
		{
			$this->errormsg = 'Wert darf nicht laenger als 64 Zeichen sein';
			return false;
		}

		return true;
	}

	/**
	 * Speichert Variable in die Datenbank
	 * Wenn $new auf true gesetzt ist wird ein neuer Datensatz
	 * angelegt, ansonsten der Datensatz upgedated
	 * @return true wenn erfolgreich, false im Fehlerfall
	 */
	public function save($new=null)
	{
		if(is_null($new))
			$new = $this->new;

		if(!is_bool($new))
		{
			$qry ="SELECT * FROM public.tbl_variable WHERE uid=".$this->db_add_param($this->uid)." AND name=".$this->db_add_param($this->name).";";
			if($this->db_query($qry))
			{
				if($this->db_num_rows()==0)
					$new=true;
<<<<<<< HEAD
				else 
					$new=false;
			}
		}
		
=======
				else
					$new=false;
			}
		}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		//Variablen auf Gueltigkeit pruefen
		if(!$this->validate())
			return false;

		if($new)
		{
			$qry = 'INSERT INTO public.tbl_variable (uid, name, wert)
			        VALUES('.$this->db_add_param($this->uid).','.
					$this->db_add_param($this->name).','.
					$this->db_add_param($this->wert).');';
		}
		else
		{
			$qry = 'UPDATE public.tbl_variable SET'.
			       ' wert='.$this->db_add_param($this->wert).
			       " WHERE uid=".$this->db_add_param($this->uid)." AND name=".$this->db_add_param($this->name).";";
		}

		if($this->db_query($qry))
		{
			//Log schreiben
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Speichern der Variable';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Loescht einen Variableneintrag
	 */
	public function delete($name, $uid)
	{
		if($name=='' || $uid == '')
		{
			$this->errormsg = 'Name und UID muessen angegeben werden';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "DELETE FROM public.tbl_variable WHERE name=".$this->db_add_param($name)." AND uid=".$this->db_add_param($uid).';';
		
		if($this->db_query($qry))
			return true;
		else 
=======

		$qry = "DELETE FROM public.tbl_variable WHERE name=".$this->db_add_param($name)." AND uid=".$this->db_add_param($uid).';';

		if($this->db_query($qry))
			return true;
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Loeschen';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Liefert alle Variablen eines Benutzers
	 */
	public function getVars($uid)
	{
		$qry = "SELECT * FROM public.tbl_variable WHERE uid=".$this->db_add_param($uid)." ORDER BY name";
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$v = new variable();
<<<<<<< HEAD
				
				$v->uid = $row->uid;
				$v->name = $row->name;
				$v->wert = $row->wert;
				
=======

				$v->uid = $row->uid;
				$v->name = $row->name;
				$v->wert = $row->wert;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->variables[] = $v;
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
	
	/**
	 * Laedt die Variablen in ein assoziatives Array
	 * 
=======

	/**
	 * Laedt die Variablen in ein assoziatives Array
	 *
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * Zugriff von aussen mit $obj->variable->semester_aktuell
	 *
	 * @param $user
	 * @return true wenn ok, sonst false
	 */
	public function loadVariables($user)
<<<<<<< HEAD
	{			
=======
	{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if(!$this->db_query("SELECT * FROM public.tbl_variable WHERE uid=".$this->db_add_param($user).';'))
		{
			$this->errormsg.=$this->db_last_error();
			return false;
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		while($row=$this->db_fetch_object())
		{
			$this->variable->{$row->name}=$row->wert;
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		//Default Werte setzten, wenn Variable nicht gesetzt ist
		if (!isset($this->variable->semester_aktuell))
		{
			if(!$this->db_query('SELECT studiensemester_kurzbz FROM public.tbl_studiensemester WHERE ende>now() ORDER BY start LIMIT 1'))
			{
				$this->errormsg.=$this->db_last_error();
				return false;
			}
			else
			{
				if($row = $this->db_fetch_object())
				{
					$this->variable->semester_aktuell=$row->studiensemester_kurzbz;
				}
			}
		}
		//Locale auf de_at setzen wenn nicht vorhanden
		if (!isset($this->variable->locale))
			$this->variable->locale='de-AT';
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if (!isset($this->variable->db_stpl_table))
			$this->variable->db_stpl_table='stundenplandev';

		if (!isset($this->variable->emailadressentrennzeichen))
<<<<<<< HEAD
			$this->variable->emailadressentrennzeichen=',';
=======
		{
			if(defined('DEFAULT_EMAILADRESSENTRENNZEICHEN'))
				$this->variable->emailadressentrennzeichen=DEFAULT_EMAILADRESSENTRENNZEICHEN;
			else
				$this->variable->emailadressentrennzeichen=',';
		}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

		if (!isset($this->variable->db_stpl_table))
			$this->variable->db_stpl_table='stundenplan';

		if (!isset($this->variable->kontofilterstg))
			$this->variable->kontofilterstg='false';

		if (!isset($this->variable->ignore_kollision))
			$this->variable->ignore_kollision='false';

		if (!isset($this->variable->ignore_zeitsperre))
			$this->variable->ignore_zeitsperre='false';

		if (!isset($this->variable->ignore_reservierung))
			$this->variable->ignore_reservierung='false';

		if (!isset($this->variable->kollision_student))
			$this->variable->kollision_student='false';
<<<<<<< HEAD
			
		if (!isset($this->variable->max_kollision))
			$this->variable->max_kollision='0';
		return true;
	}
		
=======

		if (!isset($this->variable->max_kollision))
			$this->variable->max_kollision='0';

		if (!isset($this->variable->alle_unr_mitladen))
			$this->variable->alle_unr_mitladen='false';

		if (!isset($this->variable->allow_lehrstunde_drop))
			$this->variable->allow_lehrstunde_drop='false';

		return true;
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}
?>
