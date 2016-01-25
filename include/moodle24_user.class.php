<?php
/* Copyright (C) 2013 FH Technikum-Wien
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
 * Authors: Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at> and
 */
/*
 * Connector fuer Moodle 2.4 User
<<<<<<< HEAD
 * 
 * FHComplete Moodle Plugin muss installiert sein fuer
 * Webservice Funktion 'fhcomplete_user_get_users' 
=======
 *
 * FHComplete Moodle Plugin muss installiert sein fuer
 * Webservice Funktion 'fhcomplete_user_get_users'
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
 */
require_once(dirname(__FILE__).'/basis_db.class.php');
require_once(dirname(__FILE__).'/moodle.class.php');

class moodle24_user extends basis_db
{
	public $log=''; 			//log message fuer Syncro
	public $log_public='';		//log message fuer Syncro
	public $sync_create=0; 	//anzahl der durchgefuehrten zuteilungen beim syncro
	public $group_update=0;	//anzahl der updates an gruppen
	private $serverurl;
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	public $mdl_user_id;
	public $mdl_user_username;
	public $mdl_user_firstname;
	public $mdl_user_lastname;
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Konstruktor
	 */
	public function __construct()
	{
		$moodle = new moodle();
		$pfad = $moodle->getPfad('2.4');
		$this->serverurl=$pfad.'/webservice/soap/server.php?wsdl=1&wstoken='.MOODLE_TOKEN24.'&'.microtime(true);
		return true;
	}

	/**
	 * Laedt einen Moodle User
	 *
	 * @param $uid
	 * @return boolean
	 */
	public function loaduser($uid)
	{
<<<<<<< HEAD
		$client = new SoapClient($this->serverurl); 
		$response = $client->fhcomplete_user_get_users(array(array('key'=>'username', 'value'=>$uid)));

		if(isset($response['users'][0]))
		{
			$this->mdl_user_id = $response['users'][0]['id'];
			$this->mdl_user_username = $response['users'][0]['username'];
			$this->mdl_user_firstname = $response['users'][0]['firstname'];
			$this->mdl_user_lastname = $response['users'][0]['lastname'];
			return true;
		}
		else 
		{
			$this->errormsg = 'Fehler beim Laden des Users';
			return false;
		}
	}
	
	/**
	 * Liefert ein Array mit allen Lektoren die
	 * zu dem Moodle Kurs zugeteilt sind 
=======
		try
		{
			$client = new SoapClient($this->serverurl);
			$response = $client->fhcomplete_user_get_users(array(array('key'=>'username', 'value'=>$uid)));

			if(isset($response['users'][0]))
			{
				$this->mdl_user_id = $response['users'][0]['id'];
				$this->mdl_user_username = $response['users'][0]['username'];
				$this->mdl_user_firstname = $response['users'][0]['firstname'];
				$this->mdl_user_lastname = $response['users'][0]['lastname'];
				return true;
			}
			else
			{
				$this->errormsg = 'Fehler beim Laden des Users';
				return false;
			}
		}
		catch (SoapFault $E)
		{
			$this->errormsg.="SOAP Fehler beim Laden des Users: ".$E->faultstring;
			return false;
		}
	}

	/**
	 * Liefert ein Array mit allen Lektoren die
	 * zu dem Moodle Kurs zugeteilt sind
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 */
	public function getMitarbeiter($mdl_course_id)
	{
		//Mitarbeiter laden die zu diesem Kurs zugeteilt sind
<<<<<<< HEAD
		$qry = "SELECT 
					mitarbeiter_uid
				FROM 
					lehre.tbl_lehreinheitmitarbeiter JOIN lehre.tbl_moodle USING(lehreinheit_id) 
				WHERE 
					moodle_version='2.4'
					AND mdl_course_id=".$this->db_add_param($mdl_course_id, FHC_INTEGER)."
				UNION
				SELECT 
					mitarbeiter_uid 
				FROM 
					lehre.tbl_lehreinheitmitarbeiter JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
					JOIN lehre.tbl_moodle USING(lehrveranstaltung_id) 
				WHERE 
=======
		$qry = "SELECT
					mitarbeiter_uid
				FROM
					lehre.tbl_lehreinheitmitarbeiter JOIN lehre.tbl_moodle USING(lehreinheit_id)
				WHERE
					moodle_version='2.4'
					AND mdl_course_id=".$this->db_add_param($mdl_course_id, FHC_INTEGER)."
				UNION
				SELECT
					mitarbeiter_uid
				FROM
					lehre.tbl_lehreinheitmitarbeiter JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
					JOIN lehre.tbl_moodle USING(lehrveranstaltung_id)
				WHERE
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					moodle_version='2.4'
					AND tbl_lehreinheit.studiensemester_kurzbz=tbl_moodle.studiensemester_kurzbz
					AND mdl_course_id=".$this->db_add_param($mdl_course_id, FHC_INTEGER);
		$mitarbeiter=array();
		if($this->db_query($qry))
		{
			while($row_ma = $this->db_fetch_object())
			{
				$mitarbeiter[] = $row_ma->mitarbeiter_uid;
			}
			return $mitarbeiter;
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg='Fehler beim Laden der Mitarbeiter';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Synchronisiert die Lektoren der Lehreinheiten
	 * mit denen des Moodle Kurses
	 * @param $mdl_course_id ID des MoodleKurses
	 *        lehrveranstaltung_id wird nur angegeben beim Syncro von Testkursen
	 *        studiensemester_kurzbz wird nur angegeben beim Syncro von Testkursen
	 * @return true wenn ok, false wenn Fehler
	 */
	public function sync_lektoren($mdl_course_id, $lehrveranstaltung_id=null, $studiensemester_kurzbz=null)
	{
		//Mitarbeiter laden die zu diesem Kurs zugeteilt sind
		if(!is_null($lehrveranstaltung_id) && !is_null($studiensemester_kurzbz))
		{
			//Bei Testkursen werden alle Lektoren einer Lehrveranstaltung zugeteilt
			//da hier kein Eintrag in der tbl_moodle vorhanden ist, werden die Lektoren direkt aus
			//der tbl_lehreinheitmitarbeiter geholt.
<<<<<<< HEAD
			$qry = "SELECT 
						mitarbeiter_uid 
					FROM 
						lehre.tbl_lehreinheitmitarbeiter 
						JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
					WHERE 
						lehrveranstaltung_id=".$this->db_add_param($lehrveranstaltung_id, FHC_INTEGER)." 
						AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);	
		}
		else 
		{
			$qry = "SELECT 
						mitarbeiter_uid
					FROM 
						lehre.tbl_lehreinheitmitarbeiter JOIN lehre.tbl_moodle USING(lehreinheit_id) 
					WHERE
						moodle_version='2.4' 
						AND mdl_course_id=".$this->db_add_param($mdl_course_id, FHC_INTEGER)."
						AND mitarbeiter_uid not like '_Dummy%'
					UNION
					SELECT 
						mitarbeiter_uid 
					FROM 
						lehre.tbl_lehreinheitmitarbeiter JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
						JOIN lehre.tbl_moodle USING(lehrveranstaltung_id) 
					WHERE 
=======
			$qry = "SELECT
						mitarbeiter_uid
					FROM
						lehre.tbl_lehreinheitmitarbeiter
						JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
					WHERE
						lehrveranstaltung_id=".$this->db_add_param($lehrveranstaltung_id, FHC_INTEGER)."
						AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);
		}
		else
		{
			$qry = "SELECT
						mitarbeiter_uid
					FROM
						lehre.tbl_lehreinheitmitarbeiter JOIN lehre.tbl_moodle USING(lehreinheit_id)
					WHERE
						moodle_version='2.4'
						AND mdl_course_id=".$this->db_add_param($mdl_course_id, FHC_INTEGER)."
						AND mitarbeiter_uid not like '_Dummy%'
					UNION
					SELECT
						mitarbeiter_uid
					FROM
						lehre.tbl_lehreinheitmitarbeiter JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
						JOIN lehre.tbl_moodle USING(lehrveranstaltung_id)
					WHERE
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
						moodle_version='2.4'
						AND tbl_lehreinheit.studiensemester_kurzbz=tbl_moodle.studiensemester_kurzbz
						AND mdl_course_id=".$this->db_add_param($mdl_course_id, FHC_INTEGER)."
						AND mitarbeiter_uid not like '_Dummy%'";
		}
		$mitarbeiter='';

<<<<<<< HEAD
		$client = new SoapClient($this->serverurl); 
		$enrolled_users = $client->core_enrol_get_enrolled_users($mdl_course_id,array(array('name'=>'userfields','value'=>'id,username')));

		if($result_ma = $this->db_query($qry))
		{			
=======
		try
		{
			$client = new SoapClient($this->serverurl);
			$enrolled_users = $client->core_enrol_get_enrolled_users($mdl_course_id,array(array('name'=>'userfields','value'=>'id,username')));
		}
		catch (SoapFault $E)
		{
			$this->errormsg.="SOAP Fehler beim Laden der Teilnehmer des Kurses: ".$E->faultstring;
			return false;
		}

		if($result_ma = $this->db_query($qry))
		{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			while($row_ma = $this->db_fetch_object($result_ma))
			{

				$user_zugeteilt=false;
				foreach($enrolled_users as $user)
				{
					if($user['username']==$row_ma->mitarbeiter_uid)
					{
						$user_zugeteilt=true;
						break;
					}
				}
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				if(!$user_zugeteilt)
				{

					//MoodleID des Users holen bzw ggf neu anlegen
					if(!$this->loaduser($row_ma->mitarbeiter_uid))
					{
						//User anlegen
						if(!$this->createUser($row_ma->mitarbeiter_uid))
						{
							$this->errormsg = "Fehler beim Anlegen des Users $row_ma->mitarbeiter_uid: $this->errormsg";
							return false;
						}
<<<<<<< HEAD
						else 
							$this->errormsg = '';
					}
				
=======
						else
							$this->errormsg = '';
					}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					if($mitarbeiter!='')
						$mitarbeiter.=',';
					$mitarbeiter.=$this->mdl_user_id;

					//Mitarbeiter ist noch nicht zugeteilt.
					$data = new stdClass();
					$data->roleid=3; // 3=Lektor
					$data->userid=$this->mdl_user_id;
					$data->courseid=$mdl_course_id;

<<<<<<< HEAD
					$client = new SoapClient($this->serverurl); 
					$client->enrol_manual_enrol_users(array($data));

					$this->log.="\nLektorIn $this->mdl_user_firstname $this->mdl_user_lastname wurde zum Kurs hinzugefügt";
					$this->log_public.="\nLektorIn $this->mdl_user_firstname $this->mdl_user_lastname wurde zum Kurs hinzugefügt";
					$this->sync_create++;

				}
			}
			
			return true;
		}
		else 
=======
					try
					{
						$client = new SoapClient($this->serverurl);
						$client->enrol_manual_enrol_users(array($data));

						$this->log.="\nLektorIn $this->mdl_user_firstname $this->mdl_user_lastname wurde zum Kurs hinzugefügt";
						$this->log_public.="\nLektorIn $this->mdl_user_firstname $this->mdl_user_lastname wurde zum Kurs hinzugefügt";
						$this->sync_create++;
					}
					catch (SoapFault $E)
					{
						$this->errormsg.="SOAP Fehler beim zuteilen der Teilnehmer des Kurses: ".$E->faultstring;
						return false;
					}
				}
			}

			return true;
		}
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Ermitteln der Zugeteilten Lektoren';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Synchronisiert die Studenten der Lehreinheiten
	 * mit denen des Moodle Kurses
	 * @param $mdl_course_id ID des MoodleKurses
	 * @return true wenn ok, false wenn Fehler
	 */
	public function sync_studenten($mdl_course_id)
	{
		$vorhandenegruppen=array();
		$this->gruppenzuordnungen=array();
		$groupmembertoadd = array();
		$userstoenroll=array();

		//Studentengruppen laden die zu diesem Kurs zugeteilt sind
<<<<<<< HEAD
		$qry = "SELECT 
					studiengang_kz, semester, verband, gruppe, gruppe_kurzbz, tbl_moodle.studiensemester_kurzbz, tbl_moodle.gruppen
				FROM 
					lehre.tbl_lehreinheitgruppe JOIN lehre.tbl_moodle USING(lehreinheit_id) 
				WHERE 
					moodle_version='2.4'
					AND mdl_course_id=".$this->db_add_param($mdl_course_id)."
				UNION
				SELECT 
					studiengang_kz, semester, verband, gruppe, gruppe_kurzbz, tbl_moodle.studiensemester_kurzbz, tbl_moodle.gruppen
				FROM 
					lehre.tbl_lehreinheitgruppe JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
					JOIN lehre.tbl_moodle USING(lehrveranstaltung_id) 
				WHERE 
=======
		$qry = "SELECT
					studiengang_kz, semester, verband, gruppe, gruppe_kurzbz, tbl_moodle.studiensemester_kurzbz, tbl_moodle.gruppen
				FROM
					lehre.tbl_lehreinheitgruppe JOIN lehre.tbl_moodle USING(lehreinheit_id)
				WHERE
					moodle_version='2.4'
					AND mdl_course_id=".$this->db_add_param($mdl_course_id)."
				UNION
				SELECT
					studiengang_kz, semester, verband, gruppe, gruppe_kurzbz, tbl_moodle.studiensemester_kurzbz, tbl_moodle.gruppen
				FROM
					lehre.tbl_lehreinheitgruppe JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
					JOIN lehre.tbl_moodle USING(lehrveranstaltung_id)
				WHERE
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					moodle_version='2.4'
					AND tbl_lehreinheit.studiensemester_kurzbz=tbl_moodle.studiensemester_kurzbz
					AND mdl_course_id=".$this->db_add_param($mdl_course_id);
		$studenten='';

<<<<<<< HEAD
		$client = new SoapClient($this->serverurl); 
		$enrolled_users = $client->core_enrol_get_enrolled_users($mdl_course_id, array(array('name'=>'userfields','value'=>'id,username')));

		if($result_std = $this->db_query($qry))
		{			
=======
		try
		{
			$client = new SoapClient($this->serverurl);
			$enrolled_users = $client->core_enrol_get_enrolled_users($mdl_course_id, array(array('name'=>'userfields','value'=>'id,username')));
		}
		catch (SoapFault $E)
		{
			$this->errormsg.="SOAP Fehler beim Laden der Teilnehmer des Kurses: ".$E->faultstring;
			return false;
		}

		if($result_std = $this->db_query($qry))
		{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			while($row_std = $this->db_fetch_object($result_std))
			{
				$this->mdl_user_id='';

				//Schauen ob fuer diesen Kurs die Gruppen mitgesynct werden sollen
				$gruppensync = $this->db_parse_bool($row_std->gruppen);
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				//Studenten dieser Gruppe holen

				if($row_std->gruppe_kurzbz=='') //LVB Gruppe
				{
					$qry = "SELECT
								distinct student_uid
							FROM
								public.tbl_studentlehrverband
							WHERE
								studiensemester_kurzbz=".$this->db_add_param($row_std->studiensemester_kurzbz)." AND
								studiengang_kz = ".$this->db_add_param($row_std->studiengang_kz)." AND
								semester = ".$this->db_add_param($row_std->semester);

					if(trim($row_std->verband)!='')
					{
						$qry.=" AND verband = ".$this->db_add_param($row_std->verband);
						if(trim($row_std->gruppe)!='')
						{
							$qry.=" AND gruppe = ".$this->db_add_param($row_std->gruppe);
						}
					}
					$studiengang_obj = new studiengang();
					$studiengang_obj->load($row_std->studiengang_kz);
					$gruppenbezeichnung = $studiengang_obj->kuerzel.'-'.trim($row_std->semester).trim($row_std->verband).trim($row_std->gruppe);
				}
				else //Spezialgruppe
				{
					$qry = "SELECT
								distinct uid as student_uid
							FROM
								public.tbl_benutzergruppe
							WHERE
								gruppe_kurzbz=".$this->db_add_param($row_std->gruppe_kurzbz)." AND
								studiensemester_kurzbz=".$this->db_add_param($row_std->studiensemester_kurzbz);
					$gruppenbezeichnung = $row_std->gruppe_kurzbz;
				}

				if($result_user = $this->db_query($qry))
				{
					while($row_user = $this->db_fetch_object($result_user))
					{

						//Nachschauen ob dieser Student bereits zugeteilt ist

						$user_zugeteilt=false;
						foreach($enrolled_users as $user)
						{
							if($user['username']==$row_user->student_uid)
							{
								$user_zugeteilt=true;
								$this->mdl_user_id=$user['id'];
								break;
							}
						}

						if(!$user_zugeteilt)
						{

							//MoodleID des Users holen bzw ggf neu anlegen
							if(!$this->loaduser($row_user->student_uid))
							{
								//User anlegen
								if(!$this->createUser($row_user->student_uid))
								{
									$this->errormsg = "Fehler beim Anlegen des Users $row_user->student_uid: $this->errormsg";
									return false;
								}
<<<<<<< HEAD
								else 
									$this->errormsg = '';
							}
						
							if($studenten!='')
								$studenten.=',';
							$studenten.=$this->mdl_user_id;
						

							//Student ist noch nicht zugeteilt.
							
=======
								else
									$this->errormsg = '';
							}

							if($studenten!='')
								$studenten.=',';
							$studenten.=$this->mdl_user_id;


							//Student ist noch nicht zugeteilt.

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
							$data = new stdClass();
							$data->roleid=5; // 5=Teilnehmer/Student
							$data->userid=$this->mdl_user_id;
							$data->courseid=$mdl_course_id;

							$userstoenroll[]=$data;

							$this->log.="\nStudentIn $row_user->student_uid wurde zum Kurs hinzugefügt";
							$this->log_public.="\nStudentIn $row_user->student_uid wurde zum Kurs hinzugefügt";
							$this->sync_create++;
						}

						//Gruppenzuteilung
						if($gruppensync)
						{
							if(!isset($vorhandenegruppen[$gruppenbezeichnung]))
							{
								//Schauen ob die Gruppe vorhanden ist
								if(!$groupid = $this->getGroup($mdl_course_id, $gruppenbezeichnung))
								{
									//wenn nicht dann anlegen
									if(!$groupid = $this->createGroup($mdl_course_id, $gruppenbezeichnung))
									{
										$this->log.="\nGruppen Anlegen Failed $gruppenbezeichnung $mdl_course_id $groupid";
										continue;
									}
									$this->group_update++;
									$this->log.="\nes wurde eine neue Gruppe angelgt: $gruppenbezeichnung ID $groupid";
									$this->log_public.="\nes wurde eine neue Gruppe angelgt: $gruppenbezeichnung";
								}
								$vorhandenegruppen[$gruppenbezeichnung]=$groupid;
							}
							else
								$groupid=$vorhandenegruppen[$gruppenbezeichnung];

							//if($this->mdl_user_id=='')
							//	$this->loaduser($row_user->student_uid);
							//Schauen ob eine Zuteilung zu dieser Gruppe vorhanden ist
							if(!$this->getGroupMember($groupid, $this->mdl_user_id))
							{
								//wenn nicht dann zuteilen
								$groupmembertoadd[] = array('groupid'=>$groupid,'userid'=>$this->mdl_user_id);
								//$this->createGroupMember($groupid, $this->mdl_user_id);
								$this->group_update++;
								$this->log.="\nStudentIn $row_user->student_uid wurde der Gruppe $gruppenbezeichnung ($groupid) zugeordnet";
								$this->log_public.="\nStudentIn $row_user->student_uid wurde der Gruppe $gruppenbezeichnung zugeordnet";
							}
<<<<<<< HEAD
						}						
=======
						}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					}
				}
			}

			if(count($userstoenroll)>0)
			{
<<<<<<< HEAD
				$client = new SoapClient($this->serverurl); 
				$client->enrol_manual_enrol_users($userstoenroll);
				// Wenn User zum Kurs hinzugefuegt werden, muss eine kleine Pause eingelegt werden
				// damit sich Moodle wieder beruhigt, sonst werden die Gruppenzuordnungen nicht korrekt gesetzt
				sleep(1);
=======
				try
				{
					$client = new SoapClient($this->serverurl);
					$client->enrol_manual_enrol_users($userstoenroll);
					// Wenn User zum Kurs hinzugefuegt werden, muss eine kleine Pause eingelegt werden
					// damit sich Moodle wieder beruhigt, sonst werden die Gruppenzuordnungen nicht korrekt gesetzt
					// die Pause ist abgaengig von der Anzahl der User die neu angelegt werden
					usleep(count($userstoenroll)*1000);
				}
				catch (SoapFault $E)
				{
					$this->errormsg.="SOAP Fehler beim Zuteilen der Teilnehmer des Kurses: ".$E->faultstring;
					return false;
				}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			}

			if(count($groupmembertoadd)>0)
			{
<<<<<<< HEAD
				$client = new SoapClient($this->serverurl); 
				$groupresult = $client->core_group_add_group_members($groupmembertoadd);
				//$this->log.="\n\n".print_r($groupmembertoadd,true)."\n".print_r($groupresult,true);
			}
				
			return true;
		}
		else 
=======
				$client = new SoapClient($this->serverurl);
				$groupresult = $client->core_group_add_group_members($groupmembertoadd);
				//$this->log.="\n\n".print_r($groupmembertoadd,true)."\n".print_r($groupresult,true);
			}

			return true;
		}
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Ermitteln der Zugeteilten Studenten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Schaut ob eine Zuteilung von Person zu Gruppe
	 * existiert
	 * @param grouid ID der Gruppe
	 *        userid MoodleID des Users
	 * @return true wenn zugeteilt sonst false
	 */
	public function getGroupMember($groupid, $userid)
	{
		if(!isset($this->gruppenzuordnungen[$groupid]))
		{
<<<<<<< HEAD
			$client = new SoapClient($this->serverurl); 
			$response = $client->core_group_get_group_members(array($groupid));

			if(isset($response[0]['userids']))
			{
				$this->gruppenzuordnungen[$groupid]=$response[0]['userids'];
			}
=======
			try
			{
				$client = new SoapClient($this->serverurl);
				$response = $client->core_group_get_group_members(array($groupid));

				if(isset($response[0]['userids']))
				{
					$this->gruppenzuordnungen[$groupid]=$response[0]['userids'];
				}
			}
			catch (SoapFault $E)
			{
				$this->errormsg.="SOAP Fehler beim Laden der Gruppenzuordnung: ".$E->faultstring;
				return false;
			}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}

		foreach($this->gruppenzuordnungen[$groupid] as $id)
		{
			if($id==$userid)
				return true;
		}
<<<<<<< HEAD
		
		return false;
	}
	
	/**
	 * Legt eine Zuteilung eines Users zu 
=======

		return false;
	}

	/**
	 * Legt eine Zuteilung eines Users zu
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * einer Gruppe an
	 * @param groupid ID der Gruppe
	 *        userid ID des Users
	 * @return boolean
	 */
	public function createGroupMember($groupid, $userid)
	{
<<<<<<< HEAD
		$client = new SoapClient($this->serverurl); 
		$response = $client->core_group_add_group_members(array(array('groupid'=>$groupid, 'userid'=>$userid)));
		if(isset($response[0]))
			return true;
		else
			return false;
	}
	
=======
		try
		{
			$client = new SoapClient($this->serverurl);
			$response = $client->core_group_add_group_members(array(array('groupid'=>$groupid, 'userid'=>$userid)));
			if(isset($response[0]))
				return true;
			else
				return false;
		}
		catch (SoapFault $E)
		{
			$this->errormsg.="SOAP Fehler bei zuteilen zu Gruppe: ".$E->faultstring;
			return false;
		}
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Holt die ID einer MoodleGruppe
	 * @param $mdl_course_id ID des Kurses
	 *        $gruppenbezeichnung Name der Gruppe
	 * @return GruppenID wenn ok, false im Fehlerfall
	 */
	public function getGroup($mdl_course_id, $gruppenbezeichnung)
	{
<<<<<<< HEAD
		$client = @new SoapClient($this->serverurl);
		try
		{ 
=======
		try
		{
			$client = new SoapClient($this->serverurl);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$response = $client->core_group_get_course_groups($mdl_course_id);
			foreach($response as $row)
			{
				if($row['name']==$gruppenbezeichnung)
					return $row['id'];
			}
		}
<<<<<<< HEAD
		catch (SoapFault $E) 
		{ 
=======
		catch (SoapFault $E)
		{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
    		$this->log.="Fehler beim Laden der Gruppe $mdl_course_id, $gruppenbezeichnung: ".$E->faultstring;
    		return false;
		}

		$this->errormsg = "Gruppe wurde nicht gefunden $gruppenbezeichnung";
		return false;
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Legt eine MoodleGruppe zu einem Kurs an
	 * @param mdl_course_id ID des MoodleKuses
	 *        gruppenbezeichnung Bezeichnung der Gruppe
	 * @return ID der Gruppe wenn ok, false im Fehlerfall
	 */
	public function createGroup($mdl_course_id,  $gruppenbezeichnung)
	{
<<<<<<< HEAD
		$client = new SoapClient($this->serverurl); 
		$data = new stdClass();
		$data->courseid=$mdl_course_id;
		$data->name = $gruppenbezeichnung;
		$data->description = $gruppenbezeichnung;

		$response = $client->core_group_create_groups(array($data));

		if(isset($response[0]))
		{
			return $response[0]['id'];
		}
		else
		{
			$this->errormsg = 'Fehler beim Anlegen der Gruppe';
			return false;
		}
	}
		
=======
		try
		{
			$client = new SoapClient($this->serverurl);
			$data = new stdClass();
			$data->courseid=$mdl_course_id;
			$data->name = $gruppenbezeichnung;
			$data->description = $gruppenbezeichnung;

			$response = $client->core_group_create_groups(array($data));

			if(isset($response[0]))
			{
				return $response[0]['id'];
			}
			else
			{
				$this->errormsg = 'Fehler beim Anlegen der Gruppe';
				return false;
			}
		}
		catch (SoapFault $E)
		{
			$this->errormsg.="SOAP Fehler beim Anlegen der Gruppe: ".$E->faultstring;
			return false;
		}
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Legt einen User im Moodle an
	 * @param $uid UID der Person die angelegt werden soll
	 * @return true wenn ok, false wenn Fehler
	 */
	public function createUser($uid)
	{
		if($uid=='_DummyLektor')
			return true;

		$qry = "SELECT uid, vorname, nachname FROM campus.vw_benutzer WHERE uid=".$this->db_add_param($uid);
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$username = $row->uid;
				$vorname = $row->vorname;
				$nachname = $row->nachname;

				$user = new stdClass();
				$user->username = $username;
<<<<<<< HEAD
				/* 
=======
				/*
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				 Passwort muss gesetzt werden damit das Anlegen funktioniert.
				 Es wird ein random Passwort gesetzt
				 Dieses wird beim Login nicht verwendet da ueber ldap authentifiziert wird.
				 Prefix ist noetig damit es nicht zu Problemen kommt wenn
				 im Moodle die Passwort Policy aktiviert ist
				*/
<<<<<<< HEAD
				$user->password = "FHCv!A2".hash('sha512', rand()); 
=======
				$user->password = "FHCv!A2".hash('sha512', rand());
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$user->firstname = $vorname;
				$user->lastname = $nachname;
				$user->email = $username.'@'.DOMAIN;
				$user->auth = 'ldap';
				$user->idnumber = $username;
				$user->lang = 'en';

<<<<<<< HEAD
				$client = new SoapClient($this->serverurl); 
				$response = $client->core_user_create_users(array($user));

				if(isset($response[0]))
				{
					$this->mdl_user_id = $response[0]['id'];
					return true;
				}
				else
				{
					$this->errormsg = 'Fehler beim Laden des Users';
					return false;
=======
				try
				{

					$client = new SoapClient($this->serverurl);
					$response = $client->core_user_create_users(array($user));

					if(isset($response[0]))
					{
						$this->mdl_user_id = $response[0]['id'];
						return true;
					}
					else
					{
						$this->errormsg = 'Fehler beim Laden des Users';
						return false;
					}
				}
				catch (SoapFault $E)
				{
					$this->errormsg.="SOAP Fehler beim Anlegen der User: ".$E->faultstring.' '.(isset($E->detail)?$E->detail:'').' data:'.$username;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				}
			}
			else
			{
				$this->errormsg = 'Fehler beim Laden des Users';
				return false;
			}
		}
		else
		{
			$this->errormsg='Fehler beim Laden des Users';
			return false;
		}
<<<<<<< HEAD
	}	
	
=======
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Teilt die TestStudenten zu einem Testkurs zu
	 * @param mdl_course_id ID des Moodle Kurses
	 */
	public function createTestStudentenZuordnung($mdl_course_id)
	{
		//Context des Kurses holen
		$mdlcourse = new moodle24_course();
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		$users = array('student1', 'student2', 'student3');

		foreach ($users as $row_user)
		{
			//MoodleID des Users holen
			if(!$this->loaduser($row_user))
			{
				$this->errormsg = "Fehler beim Laden des Users $row_user: $this->errormsg";
<<<<<<< HEAD
				return false;				
=======
				return false;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			}

			$data = new stdClass();
			$data->roleid=5;
			$data->userid=$this->mdl_user_id;
			$data->courseid=$mdl_course_id;

<<<<<<< HEAD
			$client = new SoapClient($this->serverurl); 
			$client->enrol_manual_enrol_users(array($data));
			// WS-Funktion enrol_manual_enrol_users liefert immer null zurück
			// Fehler bei der Zuordnung koennen daher nicht abgefangen werden.
			// Eventuell sollten hier nochmals die Teilnehmer des Kurses geladen werden
			// um zu pruefen ob die Zuordnung erfolgreich war.
		}
		
=======
			try
			{
				$client = new SoapClient($this->serverurl);
				$client->enrol_manual_enrol_users(array($data));
				// WS-Funktion enrol_manual_enrol_users liefert immer null zurück
				// Fehler bei der Zuordnung koennen daher nicht abgefangen werden.
				// Eventuell sollten hier nochmals die Teilnehmer des Kurses geladen werden
				// um zu pruefen ob die Zuordnung erfolgreich war.
			}
			catch (SoapFault $E)
			{
				$this->errormsg.="SOAP Fehler beim Zuordnen der User: ".$E->faultstring.' '.(isset($E->detail)?$E->detail:'');
			}
		}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		return true;
	}

	/**
	 * Teilt einen User zu mehreren Moodle Kursen gleichzeitig zu
	 * @param $uid UID des Users
	 * @param $mdl_course_id_array Array mit MoodleKursIDs
	 * @param $role_id Moodle Rolle
	 */
	public function MassEnroll($uid, $mdl_course_id_array, $role_id)
	{
		//MoodleID des Users holen
		if(!$this->loaduser($uid))
		{
			$this->errormsg = "Fehler beim Laden des Users $uid: $this->errormsg";
<<<<<<< HEAD
			return false;				
=======
			return false;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}

		$param=array();

		foreach($mdl_course_id_array as $mdl_course_id)
		{
			$data = new stdClass();
			$data->roleid=$role_id;
			$data->userid=$this->mdl_user_id;
			$data->courseid=$mdl_course_id;

			$param[]=$data;
		}
<<<<<<< HEAD
		$client = new SoapClient($this->serverurl); 
		$client->enrol_manual_enrol_users($param);

		return true;
	}
=======

		try
		{
			$client = new SoapClient($this->serverurl);
			$client->enrol_manual_enrol_users($param);
		}
		catch (SoapFault $E)
		{
			$this->errormsg.="SOAP Fehler beim Zuordnen der User: ".$E->faultstring.' '.(isset($E->detail)?$E->detail:'');
			return false;
		}

		return true;
	}

	/**
	 * Teilt die Fachbereichsleiter zu den Moodle Kursen zu
	 * @param $mdl_course_id ID des MoodleKurses
	 * @return true wenn ok, false wenn Fehler
	 */
	public function sync_fachbereichsleitung($mdl_course_id)
	{
		//Leitung laden die zu diesem Kurs zugeteilt sind
		$qry = "SELECT
					distinct uid as mitarbeiter_uid
				FROM
					public.tbl_organisationseinheit
					JOIN public.tbl_benutzerfunktion USING (oe_kurzbz)
					JOIN lehre.tbl_lehrveranstaltung USING(oe_kurzbz)
					JOIN lehre.tbl_lehreinheit USING (lehrveranstaltung_id)
				WHERE
					organisationseinheittyp_kurzbz in('Institut','Fachbereich')
					AND funktion_kurzbz='Leitung'
					AND (tbl_benutzerfunktion.datum_von<=now() OR tbl_benutzerfunktion.datum_von is null)
					AND (tbl_benutzerfunktion.datum_bis>=now() OR tbl_benutzerfunktion.datum_bis is null)
					AND tbl_lehrveranstaltung.lehrveranstaltung_id IN(
						SELECT
							lehrveranstaltung_id
						FROM
							lehre.tbl_moodle
						WHERE
							moodle_version='2.4'
						AND mdl_course_id=".$this->db_add_param($mdl_course_id, FHC_INTEGER)."
						AND lehrveranstaltung_id IS NOT NULL
						UNION
						SELECT
							tbl_lehreinheit.lehrveranstaltung_id
						FROM
							lehre.tbl_moodle
							JOIN lehre.tbl_lehreinheit USING(lehreinheit_id)
						WHERE
							moodle_version='2.4'
							AND mdl_course_id=".$this->db_add_param($mdl_course_id, FHC_INTEGER)."
					)";
		$mitarbeiter='';

		try
		{
			$client = new SoapClient($this->serverurl);
			$enrolled_users = $client->core_enrol_get_enrolled_users($mdl_course_id,array(array('name'=>'userfields','value'=>'id,username')));
		}
		catch (SoapFault $E)
		{
			$this->errormsg.="SOAP Fehler beim Ermitteln der Teilnehmer: ".$E->faultstring;
			return false;
		}

		if($result_ma = $this->db_query($qry))
		{
			while($row_ma = $this->db_fetch_object($result_ma))
			{

				$user_zugeteilt=false;
				foreach($enrolled_users as $user)
				{
					if($user['username']==$row_ma->mitarbeiter_uid)
					{
						$user_zugeteilt=true;
						break;
					}
				}

				if(!$user_zugeteilt)
				{

					//MoodleID des Users holen bzw ggf neu anlegen
					if(!$this->loaduser($row_ma->mitarbeiter_uid))
					{
						//User anlegen
						if(!$this->createUser($row_ma->mitarbeiter_uid))
						{
							$this->errormsg = "Fehler beim Anlegen des Users $row_ma->mitarbeiter_uid: $this->errormsg";
							return false;
						}
						else
							$this->errormsg = '';
					}

					if($mitarbeiter!='')
						$mitarbeiter.=',';
					$mitarbeiter.=$this->mdl_user_id;

					//Mitarbeiter ist noch nicht zugeteilt.
					$data = new stdClass();
					$data->roleid=11; // 11=Fachbereichsleiter (selbst definierte rolle)
					$data->userid=$this->mdl_user_id;
					$data->courseid=$mdl_course_id;

					try
					{

						$client = new SoapClient($this->serverurl);
						$client->enrol_manual_enrol_users(array($data));

						$this->log.="\nFachbereitsleiterIn $this->mdl_user_firstname $this->mdl_user_lastname wurde zum Kurs hinzugefügt";
						$this->log_public.="\nFachbereichsleiterIn $this->mdl_user_firstname $this->mdl_user_lastname wurde zum Kurs hinzugefügt";
						$this->sync_create++;
					}
					catch (SoapFault $E)
					{
						$this->log.="Fehler beim hinzufügen von FBL: ".$E->faultstring;
					}
				}
			}

			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Ermitteln der Zugeteilten Lektoren';
			return false;
		}
	}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}
