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
<<<<<<< HEAD
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>, 
=======
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>,
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
 *          Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at> and
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at>.
 */
/**
<<<<<<< HEAD
 * Klasse aufmerksamdurch 
 * @create 02-01-2007
 */
require_once(dirname(__FILE__).'/basis_db.class.php');
=======
 * Klasse aufmerksamdurch
 * @create 02-01-2007
 */
require_once(dirname(__FILE__).'/basis_db.class.php');
require_once(dirname(__FILE__).'/sprache.class.php');
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

class aufmerksamdurch extends basis_db
{
	public $new;
	public $result = array();
<<<<<<< HEAD
	
	//Tabellenspalten
	public $aufmerksamdurch_kurzbz;
	public $beschreibung;
	public $ext_id;
	
	
=======

	//Tabellenspalten
	public $aufmerksamdurch_kurzbz;
	public $beschreibung;
	public $bezeichnung;
	public $ext_id;
	public $aktiv;


>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Konstruktor
	 * @param $aufmerksamdurch_kurzbz = ID (Default=null)
	 */
	public function __construct($aufmerksamdurch_kurzbz=null)
	{
		parent::__construct();
<<<<<<< HEAD
		
		if(!is_null($aufmerksamdurch_kurzbz))
			$this->load($aufmerksamdurch_kurzbz);
	}
	
	/**
	 * Laedt einen Datensatz
	 * @param  $aufmerksam_kurzbz ID 
=======

		if(!is_null($aufmerksamdurch_kurzbz))
			$this->load($aufmerksamdurch_kurzbz);
	}

	/**
	 * Laedt einen Datensatz
	 * @param  $aufmerksam_kurzbz ID
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function load($aufmerksam_kurzbz)
	{
		//noch nicht implementiert
		return false;
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt alle Datansaetze
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function getAll($orderby='aufmerksamdurch_kurzbz')
	{
<<<<<<< HEAD
		$qry = "SELECT * FROM public.tbl_aufmerksamdurch";
		if($orderby!='')
			$qry .= " ORDER BY ".($orderby);
		
=======
        $sprache = new sprache();
		$qry = 'SELECT *,'.$sprache->getSprachQuery('bezeichnung').' FROM public.tbl_aufmerksamdurch';
		if($orderby!='')
			$qry .= " ORDER BY ".($orderby);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$obj = new aufmerksamdurch();
<<<<<<< HEAD
				
				$obj->aufmerksamdurch_kurzbz = $row->aufmerksamdurch_kurzbz;
				$obj->beschreibung = $row->beschreibung;
				
=======

				$obj->aufmerksamdurch_kurzbz = $row->aufmerksamdurch_kurzbz;
				$obj->beschreibung = $row->beschreibung;
                $obj->bezeichnung=$sprache->parseSprachResult('bezeichnung',$row);
				$obj->aktiv = $this->db_parse_bool($row->aktiv);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->result[] = $obj;
			}
			return true;
		}
<<<<<<< HEAD
		else 
		{
			$this->errormsg = 'Fehler beim Laden';
			return false;			
		}
	}
			
	/**
	 * Speichert den aktuellen Datensatz in die Datenbank	 
=======
		else
		{
			$this->errormsg = 'Fehler beim Laden';
			return false;
		}
	}

	/**
	 * Speichert den aktuellen Datensatz in die Datenbank
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * Wenn $neu auf true gesetzt ist wird ein neuer Datensatz angelegt
	 * andernfalls wird der Datensatz mit der ID in $schluessel_id aktualisiert
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function save()
	{
<<<<<<< HEAD
		
		if($this->new)
		{
			//Neuen Datensatz einfuegen
					
			$qry='INSERT INTO public.tbl_aufmerksamdurch (aufmerksamdurch_kurzbz, beschreibung, ext_id) VALUES('.
			     $this->db_add_param($this->aufmerksamdurch_kurzbz).', '.
			     $this->db_add_param($this->beschreibung).', '.
			     $this->db_add_param($this->ext_id, FHC_INTEGER).');';
		}
		else
		{			
			$qry='UPDATE public.tbl_aufmerksamdurch SET '.
				'beschreibung='.$this->db_add_param($this->beschreibung).', '.
				'ext_id='.$this->db_add_param($this->ext_id).' '. 
				'WHERE aufmerksamdurch_kurzbz='.$this->db_add_param($this->aufmerksamdurch_kurzbz).';';
		}
		
		if($this->db_query($qry))
		{
			return true;		
		}
		else 
=======

		if($this->new)
		{
			//Neuen Datensatz einfuegen

			$qry='INSERT INTO public.tbl_aufmerksamdurch (aufmerksamdurch_kurzbz, beschreibung) VALUES('.
			     $this->db_add_param($this->aufmerksamdurch_kurzbz).', '.
			     $this->db_add_param($this->beschreibung).');';
		}
		else
		{
			$qry='UPDATE public.tbl_aufmerksamdurch SET '.
				'beschreibung='.$this->db_add_param($this->beschreibung).' '.
				'WHERE aufmerksamdurch_kurzbz='.$this->db_add_param($this->aufmerksamdurch_kurzbz).';';
		}

		if($this->db_query($qry))
		{
			return true;
		}
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Speichern der Daten';
			return false;
		}
	}
}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
