<?php
/* Copyright (C) 2006 Technikum-Wien
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
 *          Rudolf Hangl 		< rudolf.hangl@technikum-wien.at >
 *          Gerald Simane-Sequens 	< gerald.simane-sequens@technikum-wien.at >
 */
require_once('../../../../config/cis.config.inc.php');
<<<<<<< HEAD
=======
require_once('../../../../config/global.config.inc.php');
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
require_once('../../../../include/functions.inc.php');
require_once('../../../../include/lehrveranstaltung.class.php');
require_once('../../../../include/studiengang.class.php');
require_once('../../../../include/studiensemester.class.php');
require_once('../../../../include/lehreinheit.class.php');
require_once('../../../../include/benutzerberechtigung.class.php');
require_once('../../../../include/uebung.class.php');
require_once('../../../../include/beispiel.class.php');
require_once('../../../../include/studentnote.class.php');
require_once('../../../../include/datum.class.php');
require_once('../../../../include/legesamtnote.class.php');
require_once('../../../../include/lvgesamtnote.class.php');
require_once('../../../../include/zeugnisnote.class.php');
require_once('../../../../include/pruefung.class.php');
require_once('../../../../include/person.class.php');
require_once('../../../../include/benutzer.class.php');
require_once('../../../../include/mitarbeiter.class.php');
require_once('../../../../include/moodle19_course.class.php');
require_once('../../../../include/moodle24_course.class.php');
require_once('../../../../include/mail.class.php');
require_once('../../../../include/phrasen.class.php');
require_once('../../../../include/note.class.php');
<<<<<<< HEAD
=======
require_once('../../../../include/notenschluessel.class.php');
require_once('../../../../include/studienplan.class.php');
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

$summe_stud=0;
$summe_t2=0;
$summe_komm=0;
$summe_ng=0;

$sprache = getSprache();
$p = new phrasen($sprache);

if (!$db = new basis_db())
	die($p->t('global/fehlerBeimOeffnenDerDatenbankverbindung'));

<<<<<<< HEAD
$debg=(isset($_REQUEST['debug'])?$_REQUEST['debug']:'');	
=======
$debg=(isset($_REQUEST['debug'])?$_REQUEST['debug']:'');
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

$user = get_uid();
if(!check_lektor($user))
	die($p->t('global/keineBerechtigungFuerDieseSeite'));
$rechte = new benutzerberechtigung();
$rechte->getBerechtigungen($user);

if(isset($_GET['lvid']) && is_numeric($_GET['lvid'])) //Lehrveranstaltung_id
	$lvid = $_GET['lvid'];
else
	die($p->t('global/fehlerBeiDerParameteruebergabe'));

if(isset($_GET['lehreinheit_id']) && is_numeric($_GET['lehreinheit_id'])) //Lehreinheit_id
	$lehreinheit_id = $_GET['lehreinheit_id'];
else
	$lehreinheit_id = '';
//Laden der Lehrveranstaltung
$lv_obj = new lehrveranstaltung();
if(!$lv_obj->load($lvid))
	die($lv_obj->errormsg);

//Studiengang laden
$stg_obj = new studiengang($lv_obj->studiengang_kz);

$datum_obj = new datum();

if(isset($_GET['stsem']))
	$stsem = $_GET['stsem'];
else
	$stsem = '';

if($stsem!='' && !check_stsem($stsem))
	die($p->t('anwesenheitsliste/studiensemesterIstUngueltig'));

$datum_obj = new datum();

$uebung_id = (isset($_GET['uebung_id'])?$_GET['uebung_id']:'');
$uid = (isset($_GET['uid'])?$_GET['uid']:'');

$noten_obj = new note();
$noten_obj->getAll();

<<<<<<< HEAD
?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../../../../skin/style.css.php" rel="stylesheet" type="text/css">
<title>Gesamtnote</title>
<STYLE TYPE="text/css">

.td_datum 
{
	width:70px;
	text-align: left;
}
.td_note{
	width:50px;
	text-align:center;
}

</STYLE>
<script language="JavaScript" type="text/javascript">
<!--
<?php 
	echo "var noten_array=Array();\n";
	$noten_array=array();
	foreach($noten_obj->result as $row)
	{
		echo "noten_array['".$row->note."']='".$row->bezeichnung."';\n";
		$noten_array[$row->note]=$row->bezeichnung;
	}
?>

	function MM_jumpMenu(targ, selObj, restore)
	{
		eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");

		if(restore)
		{
			selObj.selectedIndex = 0;
		}
	}
	
	function confirmdelete()
	{
		return confirm('<?php echo $p->t('gesamtnote/wollenSieWirklichLoeschen').'!!'; ?>');
	}

=======
echo '<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="../../../../skin/style.css.php" rel="stylesheet" type="text/css">
	<title>Gesamtnote</title>
    <link href="../../../../skin/jquery.css" rel="stylesheet"  type="text/css"/>
    <link href="../../../../skin/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css">
    <script src="../../../../include/js/jquery1.9.min.js" type="text/javascript"></script>

	<style type="text/css">
	.td_datum
	{
		width:70px;
		text-align: left;
	}
	.td_note{
		width:50px;
		text-align:center;
	}
	.gradetable
	{
		background:#DCE4EF;
		border: 1px solid #FFF;
		font-size: 8pt;
		padding: 4px;
	}

	</style>
	<script language="JavaScript" type="text/javascript">

	var noten_array=Array();
';

$noten_array=array();
foreach($noten_obj->result as $row)
{
	echo "	noten_array['".$row->note."']='".addslashes($row->bezeichnung)."';\n";
	$noten_array[$row->note]['bezeichnung']=$row->bezeichnung;
	$noten_array[$row->note]['positiv']=$row->positiv;
	$noten_array[$row->note]['aktiv']=$row->aktiv;
	$noten_array[$row->note]['lehre']=$row->lehre;
}

?>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	function getTopOffset()
	{
		var x,y;
		if (self.pageYOffset) // all except Explorer
		{
			x = self.pageXOffset;
			y = self.pageYOffset;
		}
		else if (document.documentElement && document.documentElement.scrollTop)
			// Explorer 6 Strict
		{
			x = document.documentElement.scrollLeft;
			y = document.documentElement.scrollTop;
		}
		else if (document.body) // all other Explorers
		{
			x = document.body.scrollLeft;
			y = document.body.scrollTop;
		}
		return y;
	}

<<<<<<< HEAD
	// **************************************
	// * XMLHttpRequest Objekt erzeugen
	// **************************************
    var anfrage = null;

	function erzeugeAnfrage()
	{
		try
		{
			anfrage = new XMLHttpRequest();
		}
		catch (versuchmicrosoft)
		{
			try
			{
				anfrage = new ActiveXObject("Msxml12.XMLHTTP");
			}
			catch (anderesmicrosoft)
			{
				try
				{
					anfrage = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (fehlschlag)
				{
					anfrage = null;
                }
            }
        }
		if (anfrage == null)
			alert('<?php echo $p->t('global/fehleraufgetreten');?>');
    }

=======
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
    // ******************************************
    // * Note eines Studenten Speichern
    // ******************************************
	function saveLVNote(uid)
	{
<<<<<<< HEAD
		note = document.getElementById(uid).note.value;	
		note_label = document.getElementById(uid).note.label;

		note_orig = document.getElementById(uid).note_orig.value;
		//wenn die Note gleich bleibt dann abbrechen
		if 	(note == note_orig && note != "")
		{
			alert('<?php echo $p->t('gesamtnote/noteUnveraendert');?>');
			return true;
		}
		else
		{	
			//Request erzeugen und die Note speichern
			erzeugeAnfrage(); 
		    stud_uid = uid;
		    var jetzt = new Date();
			var ts = jetzt.getTime();
		    var url= '<?php echo "lvgesamtnoteeintragen.php?lvid=".addslashes($lvid)."&stsem=".addslashes($stsem); ?>';
		    url += '&submit=1&student_uid='+uid+"&note="+note+"&"+ts;
		    anfrage.open("GET", url, true);
		    anfrage.onreadystatechange = updateSeite;
		    anfrage.send(null);
		    document.getElementById(uid).note_orig.value=noten_array[note];
	    }
	}
	
	// *****************************************************
	// * Update der Seite nachdem die Note gespeichert wurde
	// *****************************************************
	function updateSeite()
	{
	    if (anfrage.readyState == 4)
	    {
	        if (anfrage.status == 200) 
	        {
	        	uid = stud_uid;
				var note = document.getElementById(uid).note.value;
	            var resp = anfrage.responseText;
	            if (resp == "neu" || resp == "update" || resp == "update_f")
	            {
					            	
=======
		note = document.getElementById(uid).note.value;
		if(document.getElementById(uid).note)
			note_label = document.getElementById(uid).note.label;
		else
			note_label='';
		if(note=='')
		{
			alert('Bitte wählen Sie eine Note aus');
			return false;
		}
		if(document.getElementById(uid).punkte)
			punkte = document.getElementById(uid).punkte.value;
		else
			punkte='';

		note_orig = document.getElementById(uid).note_orig.value;

		//Request erzeugen und die Note speichern
	    stud_uid = uid;

		var jetzt = new Date();
		var ts = jetzt.getTime();

		var url= '<?php echo "lvgesamtnoteeintragen.php?lvid=".urlencode($lvid)."&stsem=".urlencode($stsem); ?>';
	    url += '&submit=1&student_uid='+encodeURIComponent(uid)+"&note="+encodeURIComponent(note)+"&punkte="+encodeURIComponent(punkte)+"&"+ts;

		$.ajax({
			type:"GET",
			url: url,
			success:function(result)
			{
				document.getElementById(uid).note_orig.value=noten_array[note];
		     	uid = stud_uid;
				var note = document.getElementById(uid).note.value;
	            var resp = result;
	            if (resp == "neu" || resp == "update" || resp == "update_f")
	            {
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	            	notentd = document.getElementById("note_"+uid);
	            	while (notentd.childNodes.length>0)
	            	{
						notentd.removeChild(notentd.lastChild);
	            	}
<<<<<<< HEAD
	            	notenode = document.createTextNode(noten_array[note]);
=======
					if(punkte!='')
						notentext = noten_array[note]+' ('+punkte+')';
					else
						notentext = noten_array[note];
	            	notenode = document.createTextNode(notentext);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
                    notentd.appendChild(notenode);
					notenstatus = document.getElementById("status_"+uid);
					if (resp == "update_f")
                    	notenstatus.innerHTML = "<img src='../../../../skin/images/changed.png'>";
                }
                else
         		{
             		alert(resp);
             		document.getElementById(uid).note.value="";
         		}
<<<<<<< HEAD
	        } 
	        else alert("Request status:" + anfrage.status);
	    }
	}
	
	// *************************************************
	// * Formular zum Eintragen einer Pruefung erstellen
	// *************************************************
	function pruefungAnlegen(uid,datum,note,lehreinheit_id)
	{
		var str = "<form name='nachpruefung_form'><center><table style='width:95%'><tr><td colspan='2' align='right'><a href='#' onclick='closeDiv();'>X</a></td></tr>";
		
		var anlegendiv = document.getElementById("nachpruefung_div");
		var y = getTopOffset();
		y = y+50;		
		anlegendiv.style.top = y+"px";
	
		str += "<tr><td colspan='2'><b><?php echo $p->t('benotungstool/pruefungAnlegenFuer');?> "+uid+":</b></td></tr>";
		str += "<tr><td>Datum:</td>";
		str += "<td><input type='hidden' name='uid' value='"+uid+"'><input type='hidden' name='le_id' value='"+lehreinheit_id+"'><input type='text' name='datum' value='"+datum+"'> [DD.MM.YYYY]</td>";
		str += "</tr><tr><td>Note:</td>";
		str += "<td><input type='text' name='note' value='"+note+"'></td>";
		str += "</tr><tr><td colspan='2' align='center'><input type='button' name='speichern' value='<?php echo $p->t('global/speichern');?>' onclick='pruefungSpeichern();'></td></tr>";
		str += "</table></cehter></form>";		
		anlegendiv.innerHTML = str;	
		anlegendiv.style.visibility = "visible";	
	}
	
=======
  			},
  			error:function(result)
  			{
  				alert('Speichern der Note fehlgeschlagen');
  			}
  		});
	}

	// *************************************************
	// * Formular zum Eintragen einer Pruefung erstellen
	// *************************************************
	function pruefungAnlegen(uid,datum,note,lehreinheit_id,punkte)
	{
		var str = "<form name='nachpruefung_form'><center><table style='width:95%'><tr><td colspan='2' align='right'><a href='#' onclick='closeDiv();'>X</a></td></tr>";

		var anlegendiv = document.getElementById("nachpruefung_div");
		var y = getTopOffset();
		y = y+50;
		anlegendiv.style.top = y+"px";

		str += "<tr><td colspan='2'><b><?php echo $p->t('benotungstool/pruefungAnlegenFuer');?> "+uid+":</b></td></tr>";
		str += "<tr><td><?php echo $p->t('global/datum');?>:</td>";
		str += "<td><input type='hidden' name='uid' value='"+uid+"'><input type='hidden' name='le_id' value='"+lehreinheit_id+"'>";
		str += "<input type='text' id='pruefungsdatum' name='datum' size='10' value='"+datum+"'> [DD.MM.YYYY]</td></tr>";

		<?php
		if(defined('CIS_GESAMTNOTE_PUNKTE') && CIS_GESAMTNOTE_PUNKTE)
		{
			echo 'str += "<tr><td>'.$p->t('benotungstool/punkte').':</td>";';
			echo 'str += "<td><input type=\'text\' id=\'pruefungspunkte\' name=\'punkte\' size=\'10\' value=\'"+punkte+"\' oninput=\'PruefungPunkteEingabe()\'></td></tr>";';
		}
		?>

		str += "<tr><td><?php echo $p->t('benotungstool/note');?>:</td>";

		str +='<?php
			echo '<td><select name="note" id="pruefungnoteselect">';
			echo '<option value="">-- keine Auswahl --</option>';
			foreach($noten_obj->result as $row_note)
			{
				if($row_note->lehre && $row_note->aktiv)
					echo '<option value="'.$row_note->note.'">'.$row_note->bezeichnung.'</option>';
			}
			echo '</select></td>';
		?>';
		str += "</tr><tr><td colspan='2' align='center'><input type='button' name='speichern' value='<?php echo $p->t('global/speichern');?>' onclick='pruefungSpeichern();'></td></tr>";
		str += "</table></center></form>";
		anlegendiv.innerHTML = str;
		anlegendiv.style.visibility = "visible";
		$('#pruefungsdatum').datepicker();
		$('#pruefungnoteselect').val(note);
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	// **********************************************
	// * Speichern der Pruefung
	// **********************************************
	function pruefungSpeichern()
	{
		var note = document.nachpruefung_form.note.value;
<<<<<<< HEAD
		if ((note < 0) || (note > 5 && note != 7 && note != 9 && note!=16 && note!=10 && note!=14 && note != ""))
		{
			alert("<?php echo $p->t('benotungstool/noteEingebenOderLeer');?>!");
			document.getElementById(uid).note.value="";
		}		
		var datum = document.nachpruefung_form.datum.value;		
		var datum_test = datum.split(".");
		if (datum_test[0].length != 2 || datum_test[1].length != 2 || datum_test[2].length!=4 || isNaN(datum_test[2]) || datum_test[1]>12 || datum_test[1]<1 || datum_test[0]>31 || datum_test[0]<1)
			alert("Invalid Date. Format: DD.MM.YYYY");
		else
		{
			var anlegendiv = document.getElementById("nachpruefung_div");			
			
			var note = document.nachpruefung_form.note.value;
			if (note == "" || isNaN(note))
			{
					document.nachpruefung_form.note.value = "9";
					note = "9";
			}		
			var uid = document.nachpruefung_form.uid.value;
			var lehreinheit_id = document.nachpruefung_form.le_id.value;
			
			erzeugeAnfrage(); 
		    var jetzt = new Date();
			var ts = jetzt.getTime();
		    var url= '<?php echo "nachpruefungeintragen.php?lvid=$lvid&stsem=$stsem"; ?>';
		    //&lehreinheit_id=$lehreinheit_id
		    url += '&submit=1&student_uid='+uid+'&note='+note+'&datum='+datum+'&lehreinheit_id_pr='+lehreinheit_id+'&'+ts;
		    //alert(url);
		    anfrage.open("GET", url, true);
		    anfrage.onreadystatechange = updateSeitePruefung;
		    anfrage.send(null);
	    }
	}

	// ***********************************************************
	// * Nach dem Eintragen einer Pruefung die Seite aktualisieren
	// ***********************************************************
    function updateSeitePruefung()
    {
	    if (anfrage.readyState == 4)
	    {
	        if (anfrage.status == 200) 
	        {
	        	var anlegendiv = document.getElementById("nachpruefung_div");	
				var datum = 	document.nachpruefung_form.datum.value;
				var note = document.nachpruefung_form.note.value;
				var uid = document.nachpruefung_form.uid.value;
				var lehreinheit_id = document.nachpruefung_form.le_id.value;
				//var note = document.getElementById(uid).note.value;
	            var resp = anfrage.responseText;
	            
	            if (resp == "neu" || resp == "update" || resp == "update_f" || resp == "update_pr")
	            {
		     	
	            	if (resp != "update_pr")
	            	{
		                notentd = document.getElementById("note_"+uid);	            	
		            	while (notentd.childNodes.length>0)
		            	{
							notentd.removeChild(notentd.lastChild);
		            	}
		            	notenode = document.createTextNode(note);
	                    notentd.appendChild(notenode);
					}					
					notenstatus = document.getElementById("status_"+uid);
					if (resp == "update_f")
                    	notenstatus.innerHTML = "<img src='../../../../skin/images/changed.png'>";
                    document.getElementById("lvnoteneingabe_"+uid).style.visibility = "hidden";
                    
   			 		anlegendiv.innerHTML = "";
					anlegendiv.style.visibility = "hidden";
					//if (note == 9)
					//	note = " ";
					document.getElementById("span_"+uid).innerHTML = "<table><tr><td class='td_datum'>"+datum+"</td><td class='td_note'>"+note+"<td><input type='button' name='anlegen' value='&Auml;ndern' onclick='pruefungAnlegen(\""+uid+"\",\""+datum+"\",\""+note+"\",\""+lehreinheit_id+"\")'></td></tr></table>";
                }
                else
         		{
             		alert(resp);
             		document.getElementById(uid).note.value="";
         		}
	        } 
	        else 
	        	alert("Request status:" + anfrage.status);
=======
		if(document.nachpruefung_form.punkte)
			var punkte = document.nachpruefung_form.punkte.value;
		else
			var punkte='';
		var datum = document.nachpruefung_form.datum.value;
		var datum_test = datum.split(".");
		if (datum_test[0].length != 2 || datum_test[1].length != 2 || datum_test[2].length!=4 || isNaN(datum_test[2]) || datum_test[1]>12 || datum_test[1]<1 || datum_test[0]>31 || datum_test[0]<1)
			alert("Invalid Date Format: DD.MM.YYYY");
		else
		{
			var anlegendiv = document.getElementById("nachpruefung_div");

			var note = document.nachpruefung_form.note.value;
			if (note == "" || isNaN(note))
			{
				document.nachpruefung_form.note.value = "9";
				note = "9";
			}
			var uid = document.nachpruefung_form.uid.value;
			var lehreinheit_id = document.nachpruefung_form.le_id.value;

		    var jetzt = new Date();
			var ts = jetzt.getTime();
		    var url= '<?php echo "nachpruefungeintragen.php?lvid=$lvid&stsem=$stsem"; ?>';
		    url += '&submit=1&student_uid='+uid+'&note='+note+'&datum='+datum+'&lehreinheit_id_pr='+lehreinheit_id+'&punkte='+punkte+'&'+ts;

			$.ajax({
				type:"GET",
				url: url,
				success:function(result)
				{
					var anlegendiv = document.getElementById("nachpruefung_div");
					var datum = 	document.nachpruefung_form.datum.value;
					var note = document.nachpruefung_form.note.value;
					if(document.nachpruefung_form.punkte)
						var punkte = document.nachpruefung_form.punkte.value;
					else
						var punkte='';
					var uid = document.nachpruefung_form.uid.value;
					var lehreinheit_id = document.nachpruefung_form.le_id.value;
		            var resp = result;

		            if (resp == "neu" || resp == "update" || resp == "update_f" || resp == "update_pr")
		            {
		            	if (resp != "update_pr")
		            	{
			                notentd = document.getElementById("note_"+uid);
			            	while (notentd.childNodes.length>0)
			            	{
								notentd.removeChild(notentd.lastChild);
			            	}
							if(punkte!='')
								var notentext = noten_array[note]+' ('+punkte+')';
							else
								var notentext = noten_array[note];
			            	notenode = document.createTextNode(notentext);
		                    notentd.appendChild(notenode);
						}
						notenstatus = document.getElementById("status_"+uid);
						if (resp == "update_f")
	                    	notenstatus.innerHTML = "<img src='../../../../skin/images/changed.png'>";
	                    document.getElementById("lvnoteneingabe_"+uid).style.visibility = "hidden";

	   			 		anlegendiv.innerHTML = "";
						anlegendiv.style.visibility = "hidden";
						document.getElementById("span_"+uid).innerHTML = "<table><tr><td class='td_datum'>"+datum+"</td><td class='td_note'>"+noten_array[note]+"<td><input type='button' name='anlegen' value='<?php echo $p->t('global/aendern'); ?>' onclick='pruefungAnlegen(\""+uid+"\",\""+datum+"\",\""+note+"\",\""+lehreinheit_id+"\")'></td></tr></table>";
					}
	  			},
	  			error:function(result)
	  			{
	  				alert('Request fehlgeschlagen');
	  			}
	  		});
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	    }
	}

 	function closeDiv()
 	{
 		var anlegendiv = document.getElementById("nachpruefung_div");
 		anlegendiv.innerHTML = "";
 		anlegendiv.style.visibility = "hidden";
 	}
<<<<<<< HEAD
 
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
 	function OnFreigabeSubmit()
	{
		if(document.getElementById('textbox-freigabe-passwort').value.length==0)
		{
			alert('Bitte geben Sie zuerst Ihr Passwort ein!');
			return false;
		}
		return true;
	}
<<<<<<< HEAD
	
	// ****
	// * Liefert die Daten aus der Zwischenablage fuer IE und Firefox
	// * Opera und Safari unterstuetzen dies nicht
	// ****
	function getDataFromClipboard()
	{	
		if (navigator.appName.indexOf('Microsoft') > -1) 
		{
			//IE
			return clipboardData.getData("Text");
		}
		else
		{
			if(!!window.Components)
			{
				//Firefox, Mozilla, Gecko
				try
				{
					netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
				}
				catch(e)
				{
					//alert('Um den Import nutzen zu können müssen sie Ihre Sicherheitseinstellungen Ändern!\n Geben Sie hierzu in der Adresszeile ihres Browsers "about:config" ein und setzen sie, in der angezeigten Liste, den Eintrag "signed.applets.codebase_pricipal_support" auf true.');
					alert("Ihr Browser unterstuetzt diese Funktion nicht. Bitte verwenden Sie für den Noten Import einen Internet Explorer");
				}
				var clip = Components.classes["@mozilla.org/widget/clipboard;1"].getService(Components.interfaces.nsIClipboard); 
				if (!clip) 
					return false; 
				var trans = Components.classes["@mozilla.org/widget/transferable;1"].createInstance(Components.interfaces.nsITransferable); 
				if (!trans) 
					return false; 
				
				trans.addDataFlavor("text/unicode");
				
				clip.getData(trans,clip.kGlobalClipboard); 
				var str = new Object(); 
				var strLength = new Object(); 
				trans.getTransferData("text/unicode",str,strLength);
			
				if (str) str = str.value.QueryInterface(Components.interfaces.nsISupportsString); 
				if (str) pastetext = str.data.substring(0,strLength.value / 2);
				
				return pastetext;
			}
			else
			{
				//Safari, Opera, etc
				alert("Ihr Browser unterstuetzt diese Funktion nicht. Bitte verwenden Sie für den Noten Import einen Internet Explorer");
			}
		}
	}
	
	// *******************************************************************************
	// * holt die Daten aus der Zwischenablage parst diese und speichert sie in der DB
	// * Ablauf fuer den Import:
	// * - die Spalten Matrikelnummer und Note im Excel markieren
	// * - in die Zwischenablage kopieren (strg-c)
	// * - auf import klicken
	// *******************************************************************************
	function readNotenAusZwischenablage()
	{
		var data = getDataFromClipboard();
		
=======

	/**
	 * Wird bei der Punkteeingabe aufgerufen und laedt
	 * die dazupassende Noten anhand des Notenschluessels
	 */
	function PunkteEingabe(idx)
	{
		var punkte = $('#textbox-punkte-'+idx).val();
		punkte = punkte.replace(',','.');
		// Request absetzen und Note zu den Punkten holen
		if(punkte!='')
		{
			$.ajax({
				type:"POST",
				url:"lvgesamtnote_worker.php",
				data: { lehrveranstaltung_id: '<?php echo $lvid; ?>',
						punkte: punkte,
						work: 'getGradeFromPoints',
						studiensemester_kurzbz: '<?php echo $stsem;?>'
					},
				success:function(result)
				{
				    note=result;

					var notendropdown = $('#dropdown-note-'+idx);
					notendropdown.val(note);
					notendropdown.prop('disabled',true);
	  			},
	  			error:function(result)
	  			{
	  				alert('Noten ermittlung fehlgeschlagen');
	  			}
	  		});
		}
		else
		{
			var notendropdown = $('#dropdown-note-'+idx);
			notendropdown.prop('disabled',false);
		}
	}

	/**
	 * Wird bei der Punkteeingabe aufgerufen und laedt
	 * die dazupassende Noten anhand des Notenschluessels
	 */
	function PruefungPunkteEingabe()
	{
		var punkte = $('#pruefungspunkte').val();
		punkte = punkte.replace(',','.');

		// Request absetzen und Note zu den Punkten holen
		if(punkte!='')
		{
			$.ajax({
				type:"POST",
				url:"lvgesamtnote_worker.php",
				data: { lehrveranstaltung_id: '<?php echo $lvid; ?>',
						punkte: punkte,
						work: 'getGradeFromPoints',
						studiensemester_kurzbz: '<?php echo $stsem;?>'
					},
				success:function(result)
				{
				    note=result;

					var notendropdown = $('#pruefungnoteselect');
					notendropdown.val(note);
					notendropdown.prop('disabled',true);
	  			},
	  			error:function(result)
	  			{
	  				alert('Noten ermittlung fehlgeschlagen');
	  			}
	  		});
		}
		else
		{
			var notendropdown = $('#pruefungnoteselect');
			notendropdown.prop('disabled',false);
		}
	}

	// ****
	// * Oeffnet ein Fenster fuer den Import von Noten aus dem Excel
	// ****
	function GradeImport()
	{
		var str = "<form name='gradeimport_form'><center><table style='width:95%'><tr><td colspan='2' align='right'><a href='#' onclick='closeDiv();'>X</a></td></tr>";

		var anlegendiv = document.getElementById("nachpruefung_div");
		var y = getTopOffset();
		y = y+50;
		anlegendiv.style.top = y+"px";

		str += '<tr><td><?php echo $p->t('benotungstool/importAnweisung');?>:</td>';
		str += '<td></td><tr><td><textarea id="noteimporttextarea" name="notenimport"></textarea></td></tr>';
		str += "<tr><td><input type='button' name='speichern' value='<?php echo $p->t('global/speichern');?>' onclick='saveGradeBulk();'>";
		str += "</td><td></td></tr></table></center></form>";
		anlegendiv.innerHTML = str;
		anlegendiv.style.visibility = "visible";
		$('#noteimporttextarea').focus();
	}

	// Speichert die Noten ueber den Import
	function saveGradeBulk()
	{
		data = $('#noteimporttextarea').val();
		closeDiv();

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		//Reihen ermitteln
		var rows = data.split("\n");
		var i=0;
		var params='';
<<<<<<< HEAD
		for(row in rows)
		{
			zeile = rows[row].split("	");
	
			if(zeile[0]!='' && zeile[1]!='')
			{
				params=params+'&matrikelnr_'+i+'='+zeile[0]+'&note_'+i+'='+zeile[1];
				i++;
			}
		}
		
		if(i>0)
		{
			erzeugeAnfrage(); 
		    var jetzt = new Date();
			var ts = jetzt.getTime();
		    var url= '<?php echo "lvgesamtnoteeintragen.php?lvid=".addslashes($lvid)."&stsem=".addslashes($stsem); ?>';
		    url += '&submit=1&'+ts;
		    anfrage.open("POST", url, true);
		    anfrage.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		    anfrage.setRequestHeader("Connection", "close");
		    anfrage.onreadystatechange = updateSeiteMatrikelnr;
		    anfrage.send('test='+params);
=======

		var gradedata = {};

		for(row in rows)
		{
			zeile = rows[row].split("	");

			if(zeile[0]!='' && zeile[1]!='')
			{
				gradedata['matrikelnr_'+i]=zeile[0];
				<?php
				if(CIS_GESAMTNOTE_PUNKTE)
					echo "gradedata['punkte_'+i]= zeile[1];";
				else
					echo "gradedata['note_'+i]= zeile[1];";
				?>

				i++;
			}
		}

		if(i>0)
		{

		    var jetzt = new Date();
			var ts = jetzt.getTime();
		    var url= '<?php echo "lvgesamtnoteeintragen.php?lvid=".urlencode($lvid)."&stsem=".urlencode($stsem); ?>';
		    url += '&submit=1&'+ts;
		    $.ajax({
				type:"POST",
				url: url,
				data: gradedata,
				success:function(result)
				{
				    var resp = result;
		            if (resp!='')
		            {
						alert(resp);
	                }
	                window.location.reload();
	  			},
	  			error:function(result)
	  			{
	  				alert('Request fehlgeschlagen');
	  			}
	  		});

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}
		else
		{
			alert('Zum Importieren der Noten markieren sie die Spalten Kennzeichen und Note im Excel-File und kopieren sie diese in die Zwischenablage. Drücken sie danach diesen Knopf erneut, um die Noten zu importieren');
		}
	}

<<<<<<< HEAD
	// **************************************************************
	// * Seite neu laden nachdem der Request gesendet wurde und ggf 
	// * Errormsg ausgeben
	// **************************************************************
	function updateSeiteMatrikelnr()
	{
	    if (anfrage.readyState == 4)
	    {
	        if (anfrage.status == 200) 
	        {
	            var resp = anfrage.responseText;
	            if (resp!='')
	            {
					alert(resp);
                }
                //QuickNDirty
                //ToDo: Aktualisierung der geaenderten Felder per JS anstatt reload
         		//window.location.reload();
         		window.location.href=window.location.href;
	        } 
	        else alert("Request status:" + anfrage.status);
	    }
	}
//-->
</script>
<style type="text/css">
.transparent {
    filter:alpha(opacity=90);
    -moz-opacity:0.9;
    -khtml-opacity: 0.9;
    opacity: 0.9;
</style>        
=======
//-->
</script>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
</head>

<body>

<?php
//wenn eine Uebung oder LE-Gesamtnote existiert die Note aus dem Uebungstool uebernehmen
//sonst aus dem Moodle
<<<<<<< HEAD
$qry = "SELECT 
			1 
		FROM 
			lehre.tbl_lehrveranstaltung 
			JOIN lehre.tbl_lehreinheit USING(lehrveranstaltung_id)
			JOIN campus.tbl_uebung USING(lehreinheit_id)
		WHERE 
			studiensemester_kurzbz=".$db->db_add_param($stsem)." AND
			lehrveranstaltung_id=".$db->db_add_param($lvid, FHC_INTEGER)."
		UNION
		SELECT 
			1
		FROM
			campus.tbl_legesamtnote 
		WHERE 
			lehreinheit_id in (SELECT lehreinheit_id FROM lehre.tbl_lehreinheit 
								WHERE studiensemester_kurzbz=".$db->db_add_param($stsem)." AND
								lehrveranstaltung_id=".$db->db_add_param($lvid, FHC_INTEGER).")
		
=======
$qry = "SELECT
			1
		FROM
			lehre.tbl_lehrveranstaltung
			JOIN lehre.tbl_lehreinheit USING(lehrveranstaltung_id)
			JOIN campus.tbl_uebung USING(lehreinheit_id)
		WHERE
			studiensemester_kurzbz=".$db->db_add_param($stsem)." AND
			lehrveranstaltung_id=".$db->db_add_param($lvid, FHC_INTEGER)."
		UNION
		SELECT
			1
		FROM
			campus.tbl_legesamtnote
		WHERE
			lehreinheit_id in (SELECT lehreinheit_id FROM lehre.tbl_lehreinheit
								WHERE studiensemester_kurzbz=".$db->db_add_param($stsem)." AND
								lehrveranstaltung_id=".$db->db_add_param($lvid, FHC_INTEGER).")

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		";
if($result = $db->db_query($qry))
{
	if($db->db_num_rows($result)>0)
		$grade_from_moodle=false;
<<<<<<< HEAD
	else 
	{
		if(MOODLE)
			$grade_from_moodle=true;
		else 
			$grade_from_moodle=false;
	}
}
else 
	die($p->t('global/fehleraufgetreten'));

$htmlOutput='';
	
//Kopfzeile
echo '
<table width="100%"><tr><td>
<h1>&nbsp;'.$p->t('benotungstool/gesamtnote').'</h1></td><td align="right">';
=======
	else
	{
		if(MOODLE)
			$grade_from_moodle=true;
		else
			$grade_from_moodle=false;
	}
}
else
	die($p->t('global/fehleraufgetreten'));

//Kopfzeile
echo '
<table width="100%"><tr><td>
<h1>'.$p->t('benotungstool/gesamtnote').'</h1>
<h2>'.$lv_obj->bezeichnung_arr[$sprache].'</h2>
</td><td align="right">';
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

//Studiensemester laden
$stsem_obj = new studiensemester();
if($stsem=='')
	$stsem = $stsem_obj->getaktorNext();
$stsem_obj->getAll();

//Studiensemester DropDown
<<<<<<< HEAD
$stsem_content = $p->t('global/studiensemester').": <SELECT name='stsem' onChange=\"MM_jumpMenu('self',this,0)\">";
=======
$stsem_content = $p->t('global/studiensemester').": <SELECT name='stsem' onChange=\"self.location=this.options[this.selectedIndex].value\">";
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
foreach($stsem_obj->studiensemester as $studiensemester)
{
	$selected = ($stsem == $studiensemester->studiensemester_kurzbz?'selected':'');
	$stsem_content.= "<OPTION value='lvgesamtnoteverwalten.php?lvid=$lvid&stsem=$studiensemester->studiensemester_kurzbz' $selected>$studiensemester->studiensemester_kurzbz</OPTION>\n";
}
$stsem_content.= "</SELECT>\n";


if(!$rechte->isBerechtigt('admin',0) &&
   !$rechte->isBerechtigt('admin',$lv_obj->studiengang_kz) &&
   !$rechte->isBerechtigt('lehre',$lv_obj->studiengang_kz))
{
	$qry = "SELECT lehreinheit_id FROM lehre.tbl_lehrveranstaltung JOIN lehre.tbl_lehreinheit USING(lehrveranstaltung_id)
<<<<<<< HEAD
			JOIN lehre.tbl_lehreinheitmitarbeiter USING(lehreinheit_id) 
=======
			JOIN lehre.tbl_lehreinheitmitarbeiter USING(lehreinheit_id)
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			WHERE tbl_lehrveranstaltung.lehrveranstaltung_id=".$db->db_add_param($lvid, FHC_INTEGER)." AND
			tbl_lehreinheit.studiensemester_kurzbz=".$db->db_add_param($stsem)." AND tbl_lehreinheitmitarbeiter.mitarbeiter_uid=".$db->db_add_param($user).';';
	if($result = $db->db_query($qry))
	{
		if($db->db_num_rows($result)==0)
			die($p->t('global/keineBerechtigungFuerDieseSeite'));
	}
<<<<<<< HEAD
	else 
=======
	else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	{
		die($p->t('global/fehleraufgetreten'));
	}
}
echo $stsem_content;
<<<<<<< HEAD
echo '</td></tr></table>';

echo '<table width="100%"><tr>';
echo '<td class="tdwidth10">&nbsp;</td>';
echo "<td>";
echo "<b>".$lv_obj->bezeichnung_arr[$sprache]."</b>";

// lvgesamtnote für Studenten speichern
if (isset($_REQUEST["submit"]) && ($_POST["student_uid"] != ''))
{	
	$jetzt = date("Y-m-d H:i:s");	
	$student_uid = $_POST["student_uid"];
	$lvid = $_REQUEST["lvid"];
	$lvgesamtnote = new lvgesamtnote();
    if (!$lvgesamtnote->load($lvid, $student_uid, $stsem))
    {
		$lvgesamtnote->student_uid = $student_uid;
		$lvgesamtnote->lehrveranstaltung_id = $lvid;
		$lvgesamtnote->studiensemester_kurzbz = $stsem;
		$lvgesamtnote->note = $_POST["note"];
		$lvgesamtnote->mitarbeiter_uid = $user;
		$lvgesamtnote->benotungsdatum = $jetzt;
		$lvgesamtnote->freigabedatum = null;
		$lvgesamtnote->freigabevon_uid = null;
		$lvgesamtnote->bemerkung = null;
		$lvgesamtnote->updateamum = null;
		$lvgesamtnote->updatevon = null;
		$lvgesamtnote->insertamum = $jetzt;
		$lvgesamtnote->insertvon = $user;
		$new = true;
    }
    else
    {
		$lvgesamtnote->note = $_POST["note"];
		$lvgesamtnote->benotungsdatum = $jetzt;
		$lvgesamtnote->updateamum = $jetzt;
		$lvgesamtnote->updatevon = $user;
		$new = false;
	}
	if (!$lvgesamtnote->save($new))
		echo "<span class='error'>".$lvgesamtnote->errormsg."</span>";
}
=======
echo '</td></tr>';

echo '<tr>';
echo "<td>";
echo '<a href="'.$p->t('dms_link/dokuwikiGesamtnote').'" class="Item" target="_blank">'.$p->t('global/anleitung').'</a>';
if(defined('CIS_ANWESENHEITSLISTE_NOTENLISTE_ANZEIGEN') && CIS_ANWESENHEITSLISTE_NOTENLISTE_ANZEIGEN)
	echo "<br><a class='Item' href='../notenliste.xls.php?stg=$stg_obj->studiengang_kz&lvid=$lvid&stsem=$stsem'>".$p->t('benotungstool/notenlisteImport')."</a>";
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

// eingetragene lv-gesamtnoten freigeben
if (isset($_REQUEST["freigabe"]) and ($_REQUEST["freigabe"] == 1))
{
	//Passwort pruefen
	if(checkldapuser($user, $_REQUEST['passwort']))
	{
		$jetzt = date("Y-m-d H:i:s");
		$neuenoten = 0;
<<<<<<< HEAD
		$studlist = "<table border='1'><tr><td><b>".$p->t('global/personenkz')."</b></td><td><b>".$p->t('global/nachname')."</b></td><td><b>".$p->t('global/vorname')."</b></td><td><b>".$p->t('benotungstool/note')."</b></td></tr>\n";

		// studentenquery					
		$qry_stud = "SELECT 
						DISTINCT uid, vorname, nachname, matrikelnr 
					FROM 
						campus.vw_student_lehrveranstaltung 
						JOIN campus.vw_student USING(uid) 
=======
		$studlist = "<table border='1'><tr><td><b>".$p->t('global/personenkz')."</b></td><td><b>".$p->t('global/nachname')."</b></td><td><b>".$p->t('global/vorname')."</b></td>";
		if(defined('CIS_GESAMTNOTE_PUNKTE') && CIS_GESAMTNOTE_PUNKTE)
		{
			$studlist.="<td><b>".$p->t('benotungstool/punkte')."</b></td>\n";
		}
		$studlist.="<td><b>".$p->t('benotungstool/note')."</b></td></tr>\n";

		// studentenquery
		$qry_stud = "SELECT
						DISTINCT uid, vorname, nachname, matrikelnr
					FROM
						campus.vw_student_lehrveranstaltung
						JOIN campus.vw_student USING(uid)
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					WHERE
						studiensemester_kurzbz = ".$db->db_add_param($stsem)."
						AND lehrveranstaltung_id = ".$db->db_add_param($lvid, FHC_INTEGER)."
					ORDER BY nachname, vorname ";
        if($result_stud = $db->db_query($qry_stud))
		{
			$i=1;
			while($row_stud = $db->db_fetch_object($result_stud))
<<<<<<< HEAD
			{	
				$lvgesamtnote = new lvgesamtnote();
    			if ($lvgesamtnote->load($lvid,$row_stud->uid,$stsem))
    			{
					if ($lvgesamtnote->benotungsdatum > $lvgesamtnote->freigabedatum)	    				
					{	    				
    					$lvgesamtnote->freigabedatum = $jetzt;
    					$lvgesamtnote->freigabevon_uid = $user;
    					$lvgesamtnote->save($new=null);
    					$studlist .= "<tr><td>".trim($row_stud->matrikelnr)."</td><td>".trim($row_stud->nachname)."</td><td>".trim($row_stud->vorname)."</td><td>".trim($lvgesamtnote->note)."</td></tr>\n";
    					$neuenoten++;
    				}
    			}
			}	
		}
		
		$studlist .= "</table>";
		
		//mail an assistentin und den user selber verschicken	
=======
			{
				$lvgesamtnote = new lvgesamtnote();
    			if ($lvgesamtnote->load($lvid,$row_stud->uid,$stsem))
    			{
					if ($lvgesamtnote->benotungsdatum > $lvgesamtnote->freigabedatum)
					{
    					$lvgesamtnote->freigabedatum = $jetzt;
    					$lvgesamtnote->freigabevon_uid = $user;
    					$lvgesamtnote->save($new=null);
    					$studlist .= "<tr><td>".trim($row_stud->matrikelnr)."</td>";
						$studlist .= "<td>".trim($row_stud->nachname)."</td>";
						$studlist .= "<td>".trim($row_stud->vorname)."</td>";
						if(defined('CIS_GESAMTNOTE_PUNKTE') && CIS_GESAMTNOTE_PUNKTE)
						{
							$studlist.="<td>".($lvgesamtnote->punkte!=''?trim(number_format($lvgesamtnote->punkte,2)):'')."</td>\n";
						}
						$studlist.="<td>".$noten_array[trim($lvgesamtnote->note)]['bezeichnung']."</td></tr>\n";
    					$neuenoten++;
    				}
    			}
			}
		}

		$studlist .= "</table>";

		//mail an assistentin und den user selber verschicken
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if ($neuenoten > 0)
		{
			$lv = new lehrveranstaltung($lvid);
			$sg = new studiengang($lv->studiengang_kz);
			$lektor_adresse = $user."@".DOMAIN;
			$adressen = $sg->email.", ".$user."@".DOMAIN;
<<<<<<< HEAD
			
			
=======

			$studienplan = new studienplan();
			$studienplan->getStudienplanLehrveranstaltung($lvid, $stsem);
			$studienplan_bezeichnung='';
			foreach($studienplan->result as $row)
				$studienplan_bezeichnung.=$row->bezeichnung.' ';

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$mit = new mitarbeiter();
			$mit->load($user);

			$freigeber = "<b>".mb_strtoupper($user)."</b>";
<<<<<<< HEAD
			$mail = new mail($adressen, 'vilesci@'.DOMAIN, 'Notenfreigabe '.$lv->bezeichnung,'');
			$htmlcontent="<html><body><b>".$sg->kuerzel.' '.$lv->semester.'.Semester '.$lv->bezeichnung." - ".$stsem."</b> (".$lv->semester.". Sem.) <br><br>".$p->t('global/benutzer')." ".$freigeber." (".$mit->kurzbz.") ".$p->t('benotungstool/hatDieLvNotenFuerFolgendeStudenten').":<br><br>\n".$studlist."<br>".$p->t('abgabetool/mailVerschicktAn').": ".$adressen."</body></html>";
			$mail->setHTMLContent($htmlcontent);
			$mail->setReplyTo($lektor_adresse);
			$mail->send();
		}	
	}
	else 
=======
			$mail = new mail($adressen, 'vilesci@'.DOMAIN, 'Notenfreigabe '.$lv->bezeichnung." ".$lv->orgform_kurzbz.' - '.$studienplan_bezeichnung,'');
			$htmlcontent="<html><body><b>".$sg->kuerzel.' '.$lv->semester.'.Semester '.$lv->bezeichnung." ".$lv->orgform_kurzbz." - ".$stsem."</b> (".$lv->semester.". Sem.) <br><br>".$p->t('global/benutzer')." ".$freigeber." (".$mit->kurzbz.") ".$p->t('benotungstool/hatDieLvNotenFuerFolgendeStudenten').":<br><br>\n".$studlist."<br>".$p->t('abgabetool/mailVerschicktAn').": ".$adressen."</body></html>";
			$mail->setHTMLContent($htmlcontent);
			$mail->setReplyTo($lektor_adresse);
			$mail->send();
		}
	}
	else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	{
		echo '<span><font class="error">'.$p->t('gesamtnote/passwortFalsch').'</font></span>';
	}
}

<<<<<<< HEAD
echo '<table width="100%" height="10px"><tr><td>';
//echo "<h3><a href='javascript:window.history.back()'>".$p->t('global/zurueck')."</a></h3>";
echo '</td><td align="right">';
echo '<a href="'.APP_ROOT.'cms/dms.php?id='.$p->t('dms_link/benotungstoolHandbuch').'" class="Item" target="_blank">'.$p->t('benotungstool/handbuch').' (PDF)</a>';
echo '</td></tr></table>';


echo '<table width="100%" height="10px"><tr><td>';
	//echo "<h3>".$p->t('benotungstool/lvGesamtnoteVerwalten')."</h3>";
	//echo $p->t('benotungstool/noten');
echo '</td></tr></table>';
=======
if(defined('CIS_GESAMTNOTE_PUNKTE') && CIS_GESAMTNOTE_PUNKTE)
	echo '<br><a href="#" onclick="window.open(\'notenschluessel.php?lehrveranstaltung_id='.$lvid.'&stsem='.$stsem.'\',\'Grades\', \'height=200,width=350,left=50,top=50,resizable=yes,status=no,scrollbars=yes,toolbar=no,location=no,menubar=no,dependent=yes\'); return false;">'.$p->t('gesamtnote/notenschluesselanzeigen').'</a>';

echo '</td></tr></table><br>';
echo '<table width="100%" height="10px"><tr><td>';

>>>>>>> fee287127566cd5d18c55b556d178b661711c694

// alle Pruefungen für die LV holen
$studpruef_arr = array();
$pr_all = new Pruefung();
if ($pr_all->getPruefungenLV($lvid,"Termin2",$stsem))
{
	if ($pr_all->result)
	{
		foreach ($pr_all->result as $pruefung)
<<<<<<< HEAD
		{		
			$studpruef_arr[$pruefung->student_uid][$pruefung->lehreinheit_id]["note"] = $pruefung->note;
			$studpruef_arr[$pruefung->student_uid][$pruefung->lehreinheit_id]["datum"] = $datum_obj->formatDatum($pruefung->datum,'d.m.Y');
			//echo print_r($studpruef_arr[$pruefung->student_uid]);
		}	
=======
		{
			$studpruef_arr[$pruefung->student_uid][$pruefung->lehreinheit_id]["note"] = $pruefung->note;
			$studpruef_arr[$pruefung->student_uid][$pruefung->lehreinheit_id]["punkte"] = $pruefung->punkte;
			$studpruef_arr[$pruefung->student_uid][$pruefung->lehreinheit_id]["datum"] = $datum_obj->formatDatum($pruefung->datum,'d.m.Y');
		}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	}
}
$summe_t2=count($studpruef_arr);
$studpruef_komm = array();
$pr_komm = new Pruefung();
if ($pr_komm->getPruefungenLV($lvid,"kommPruef",$stsem))
{
	if ($pr_komm->result)
	{
		foreach ($pr_komm->result as $kpruefung)
<<<<<<< HEAD
		{		
			$studpruef_komm[$kpruefung->student_uid][$kpruefung->lehreinheit_id]["note"] = $kpruefung->note;
			$studpruef_komm[$kpruefung->student_uid][$kpruefung->lehreinheit_id]["datum"] = $datum_obj->formatDatum($kpruefung->datum,'d.m.Y');
		}	
=======
		{
			$studpruef_komm[$kpruefung->student_uid][$kpruefung->lehreinheit_id]["note"] = $kpruefung->note;
			$studpruef_komm[$kpruefung->student_uid][$kpruefung->lehreinheit_id]["punkte"] = $kpruefung->punkte;
			$studpruef_komm[$kpruefung->student_uid][$kpruefung->lehreinheit_id]["datum"] = $datum_obj->formatDatum($kpruefung->datum,'d.m.Y');
		}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	}
}
$summe_komm=count($studpruef_komm);

//Studentenliste
<<<<<<< HEAD
echo '<table>';
		echo "<tr>
				<td colspan='11'>&nbsp;</td>
			</tr>
			<tr>
				<td class='ContentHeader2'></td>
				<td class='ContentHeader2'>".$p->t('global/uid')."</td>
				<td class='ContentHeader2'>".$p->t('global/nachname')."</td>
				<td class='ContentHeader2'>".$p->t('global/vorname')."</td>
				<td class='ContentHeader2'>".($grade_from_moodle?''.$p->t('benotungstool/moodleNote').'':''.$p->t('benotungstool/leNoten').' (LE-ID)')."</td>
				<td class='ContentHeader2'></td>
				<td class='ContentHeader2'>".$p->t('benotungstool/lvNote')."<br><input type='button' onclick='readNotenAusZwischenablage()' value='".$p->t('benotungstool/importieren')."'></td>
				<td class='ContentHeader2' align='right'>
				<form name='freigabeform' action='".$_SERVER['PHP_SELF']."?lvid=$lvid&lehreinheit_id=$lehreinheit_id&stsem=$stsem' method='POST' onsubmit='return OnFreigabeSubmit()'><input type='hidden' name='freigabe' value='1'>
				".$p->t('global/passwort').": <input type='password' size='8' id='textbox-freigabe-passwort' name='passwort'><br><input type='submit' name='frei' value='Freigabe'>
				</form>
				</td>
				<td class='ContentHeader2'>".$p->t('benotungstool/zeugnisnote')."</td>
				<td class='ContentHeader2' colspan='2'>".$p->t('benotungstool/nachpruefung')."</td>
				<td class='ContentHeader2' colspan='2'>".$p->t('benotungstool/kommissionellePruefung')."</td>
			</tr>
			<tr>
				<td colspan='9'>&nbsp;</td>
				<td colspan='2'>
=======

echo '<table class="gradetable">';
echo "
		<tr>
			<th></th>
			<th>".$p->t('global/uid')."</th>
			<th>".$p->t('global/nachname')."</th>
			<th>".$p->t('global/vorname')."</th>
			<th>".($grade_from_moodle?''.$p->t('benotungstool/moodleNote').'':''.$p->t('benotungstool/leNoten').' (LE-ID)')."</th>
			<th>".$p->t('benotungstool/punkte').' / '.$p->t('benotungstool/note')."</th>
			<th rowspan=2>".$p->t('benotungstool/lvNote')."<br>
				<input type='button' onclick='GradeImport()' value='".$p->t('benotungstool/importieren')."'>
			</th>
			<th align='right' rowspan=2>
				<form name='freigabeform' action='".$_SERVER['PHP_SELF']."?lvid=$lvid&lehreinheit_id=$lehreinheit_id&stsem=$stsem' method='POST' onsubmit='return OnFreigabeSubmit()'>
				<input type='hidden' name='freigabe' value='1'>
				<span style='white-space:nowrap;'>".$p->t('global/passwort').": <input type='password' size='8' id='textbox-freigabe-passwort' name='passwort'></span>
				<br><input type='submit' name='frei' value='Freigabe'>
				</form>
			</th>
			<th>".$p->t('benotungstool/zeugnisnote')."</th>
			<th colspan='2'>".$p->t('benotungstool/nachpruefung')."</th>
			<th colspan='2'>".$p->t('benotungstool/kommissionellePruefung')."</th>
		</tr>
			<tr>
				<th colspan='9'>&nbsp;</th>
				<th colspan='2'>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					<table>
					<tr>
						<td class='td_datum'>".$p->t('global/datum')."</td>
						<td class='td_note'>".$p->t('benotungstool/note')."</td>
						<td></td>
					</tr>
					</table>
<<<<<<< HEAD
				</td>
				<td colspan='2'>
=======
				</th>
				<th colspan='2'>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					<table>
					<tr>
						<td class='td_datum'>".$p->t('global/datum')."</td>
						<td class='td_note'>".$p->t('benotungstool/note')."</td>
						<td></td>
					</tr>
					</table>
<<<<<<< HEAD
				</td>
			</tr>
			<tr>
				<td colspan='11'>&nbsp;</td>
			</tr>";
=======
				</th>
			</tr>
			";
>>>>>>> fee287127566cd5d18c55b556d178b661711c694


		if($grade_from_moodle)
		{
			flush();
			ob_flush();

			$moodle24 = new moodle24_course();
			$moodle24->loadNoten($lvid, $stsem);

			$moodle24_course_bezeichnung=array();

			if(count($moodle24->result)>0)
			{
				// Bezeichnungen der Moodlekurse laden
				foreach($moodle24->result as $obj)
				{
					if(!isset($moodle24_course_bezeichnung[$obj->mdl_course_id]))
					{
						$moodle24course = new moodle24_course();
						$moodle24course->load($obj->mdl_course_id);

						$moodle24_course_bezeichnung[$obj->mdl_course_id]=$moodle24course->mdl_shortname;
					}
				}
			}
		}

<<<<<<< HEAD
		// studentenquery					
		$qry_stud = "SELECT 
						DISTINCT uid, vorname, nachname, matrikelnr 
					FROM 
						campus.vw_student_lehrveranstaltung 
						JOIN campus.vw_student USING(uid) 
					WHERE 
=======
		// studentenquery
		$qry_stud = "SELECT
						DISTINCT uid, vorname, nachname, matrikelnr
					FROM
						campus.vw_student_lehrveranstaltung
						JOIN campus.vw_student USING(uid)
					WHERE
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
						studiensemester_kurzbz = ".$db->db_add_param($stsem)."
						AND lehrveranstaltung_id = ".$db->db_add_param($lvid)."
					ORDER BY nachname, vorname ";
      	$mdldaten=null;
	    if($result_stud = $db->db_query($qry_stud))
		{
			$i=1;
			$errorshown=false;
			$summe_stud=$db->db_num_rows($result_stud);
			while($row_stud = $db->db_fetch_object($result_stud))
			{
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				echo "<tr class='liste".($i%2)."'>
					<td><a href='mailto:$row_stud->uid@".DOMAIN."'><img src='../../../../skin/images/button_mail.gif'></a></td>";
				echo "
					<td>$row_stud->uid</td>
					<td>$row_stud->nachname</td>
					<td>$row_stud->vorname</td>";
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$note_les_str = '';
				$le_anz = 0;
				$note_le = 0;
				$note=0;
				if($grade_from_moodle)
				{
					//Moodle 1.9

					// Alle Moodlekursdaten zu Lehreinheit und Semester lesen wenn noch nicht belegt.
					if (is_null($mdldaten) && defined('CONN_STRING_MOODLE'))
					{
						//Noten aus Moodle
						if (!isset($moodle_course))
							$moodle_course = new moodle19_course();
<<<<<<< HEAD
							
						if (!$mdldaten = $moodle_course->loadNoten($lvid, $stsem, '', true,$debg))
							$mdldaten=''; 
					}	
					// Verarbeitet die Kursdaten
					if (!is_null($mdldaten) && is_array($mdldaten))
					{
							reset($mdldaten);		
							$title="";
							$mdl_shortname='';
	    					for ($imdldaten=0;$imdldaten<count($mdldaten) ;$imdldaten++) 
							{	

								$mdldata=$mdldaten[$imdldaten]->result;
	#							$error=(isset($mdldata[1])?$mdldata[1]:"Kurs Info ");
								$kursArr=(isset($mdldata[2])?$mdldata[2]:array());
								$kursasObj=(isset($mdldata[3])?$mdldata[3]:array());
	#							$userArr=(isset($mdldata[4])?$mdldata[4]:array());
	#							$userasObj=(isset($mdldata[5])?$mdldata[5]:array());
	#							$id=(isset($mdldata[6])?$mdldata[6]:'');
								$kursname=(isset($mdldata[7])?$mdldata[7]:'');
								$shortname=(isset($mdldata[8])?$mdldata[8]:'');
	#							$courseArr=(isset($mdldata[9])?$mdldata[9]:array());

								$note=0;
								$userGef=false;
								
								reset($kursArr);		
		    					for ($iKurs=0;$iKurs<count($kursArr) ;$iKurs++) 
								{	
									if (isset($kursArr[$iKurs]) && isset($kursArr[$iKurs][2]) && isset($kursArr[$iKurs][6]) && strtolower(trim($row_stud->uid))==strtolower(trim($kursArr[$iKurs][2])) )
									{
																	
									    $note=trim($kursArr[$iKurs][6]);
										$userGef=true;
										
=======

						if (!$mdldaten = $moodle_course->loadNoten($lvid, $stsem, '', true,$debg))
							$mdldaten='';
					}
					// Verarbeitet die Kursdaten
					if (!is_null($mdldaten) && is_array($mdldaten))
					{
							reset($mdldaten);
							$title="";
							$mdl_shortname='';
	    					for ($imdldaten=0;$imdldaten<count($mdldaten) ;$imdldaten++)
							{

								$mdldata=$mdldaten[$imdldaten]->result;
								$kursArr=(isset($mdldata[2])?$mdldata[2]:array());
								$kursasObj=(isset($mdldata[3])?$mdldata[3]:array());
								$kursname=(isset($mdldata[7])?$mdldata[7]:'');
								$shortname=(isset($mdldata[8])?$mdldata[8]:'');

								$note=0;
								$userGef=false;

								reset($kursArr);
		    					for ($iKurs=0;$iKurs<count($kursArr) ;$iKurs++)
								{
									if (isset($kursArr[$iKurs]) && isset($kursArr[$iKurs][2]) && isset($kursArr[$iKurs][6]) && strtolower(trim($row_stud->uid))==strtolower(trim($kursArr[$iKurs][2])) )
									{
									    $note=trim($kursArr[$iKurs][6]);
										$userGef=true;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
									   	if (is_numeric($note)  || $debg)
									   	{
										   	if (is_numeric($note))
										   	{
										   		$note_le += $note;
						    			   		$le_anz += 1;
<<<<<<< HEAD
											}	
=======
											}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
						    				if ($note == 5)
						    					$leneg = " style='color:red; font-weight:bold'";
				    						else
		    									$leneg = " style='font-weight:bold'";
<<<<<<< HEAD
											
										   $mdl_shortname=$mdldaten[$imdldaten]->mdl_shortname;
			  							   $title="\r\nMoodle 1.9 KursID: ".$mdldaten[$imdldaten]->mdl_course_id ."\r\n\r\n".$kursname.', '.$mdl_shortname."\r\n";
									       foreach ($kursasObj[$iKurs] as $key => $value) 
										   {
												$title.=$key."=>".$value."\r\n";
											}	
											
												
											$note_les_str .= "<span ".$leneg.">".$note."</span> <span  title='".$title."' style='font-size:10px'>(".$mdl_shortname.")</span> ";
										}	
									}	// ende If Richtiger User
									
									if ($userGef)
									{
										$iKurs=count($kursArr)+1; // diesen USER for beenden - user wurde gefunden	
									}	
=======

										   $mdl_shortname=$mdldaten[$imdldaten]->mdl_shortname;
			  							   $title="\r\nMoodle 1.9 KursID: ".$mdldaten[$imdldaten]->mdl_course_id ."\r\n\r\n".$kursname.', '.$mdl_shortname."\r\n";
									       foreach ($kursasObj[$iKurs] as $key => $value)
										   {
												$title.=$key."=>".$value."\r\n";
											}


											$note_les_str .= "<span ".$leneg.">".$note."</span> <span  title='".$title."' style='font-size:10px'>(".$mdl_shortname.")</span> ";
										}
									}	// ende If Richtiger User

									if ($userGef)
									{
										$iKurs=count($kursArr)+1; // diesen USER for beenden - user wurde gefunden
									}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

								} // ende Kursschleife
							} // MoodleKurse abarbeiten

				#echo "<p><h1> $title Anzahl Noten gef. $le_anz $note_le </h1></p>";
<<<<<<< HEAD
					}		
=======
					}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					else
					{
						if(defined('CONN_STRING_MOODLE'))
						{
							//den Error nur einmal anzeigen und nicht fuer jeden Studenten
							$moodle_course->errormsg=trim($moodle_course->errormsg);
							if(!$errorshown && !empty($moodle_course->errormsg) )
							{
								//echo '<br><b>'.$moodle_course->errormsg.'</b><br>';
								$errorshown=true;
							}
						}
					}

					// Moodle 2.4
					if(isset($moodle24) && count($moodle24->result)>0)
					{
						foreach($moodle24->result as $moodle24_noten)
						{
							if($moodle24_noten->uid==$row_stud->uid)
							{
								$note_le+=$moodle24_noten->note;
								$le_anz+=1;
<<<<<<< HEAD
								if ($moodle24_noten->note == 5)
									$leneg = " style='color:red; font-weight:bold'";
								else
									$leneg = ' style="font-weight: bold;"';
								$title="Moodle 2.4 KursID: ".$moodle24_noten->mdl_course_id.
=======
								//if ($moodle24_noten->note == 5)
								//	$leneg = " style='color:red; font-weight:bold'";
								//else
									$leneg = ' style="font-weight: bold;"';
								$title="Moodle KursID: ".$moodle24_noten->mdl_course_id.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
								"\nKursbezeichnung: ".$moodle24_course_bezeichnung[$moodle24_noten->mdl_course_id].
								"\nUser: ".$moodle24_noten->uid.
								"\nNote: $moodle24_noten->note";
								$note_les_str .= "<br><span".$leneg.">".$moodle24_noten->note."</span><span  title='".$title."' style='font-size:10px'> (".$moodle24_course_bezeichnung[$moodle24_noten->mdl_course_id].")</span> ";

							}
						}
					}
				}
<<<<<<< HEAD
				else 
=======
				else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				{
					//Noten aus Uebungstool
					$le = new lehreinheit();
					$le->load_lehreinheiten($lvid, $stsem);
<<<<<<< HEAD
					foreach($le->lehreinheiten as $l)				
					{				
						$legesamtnote = new legesamtnote($l->lehreinheit_id);
		    			
		    			if (!$legesamtnote->load($row_stud->uid,$l->lehreinheit_id))
						{    				
=======
					foreach($le->lehreinheiten as $l)
					{
						$legesamtnote = new legesamtnote($l->lehreinheit_id);

		    			if (!$legesamtnote->load($row_stud->uid,$l->lehreinheit_id))
						{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		    				//$note_les_str .= "- (".$l->lehreinheit_id.")";
		    			}
		    			else
		    			{
		    				$note_le += $legesamtnote->note;
		    				$le_anz += 1;
		    				if ($legesamtnote->note == 5)
		    					$leneg = " style='color:red; font-weight:bold'";
		    				else
		    					$leneg = "";
		    				$note_les_str .= "<span".$leneg.">".$legesamtnote->note."</span> (".$l->lehreinheit_id.") ";
		    			}
		    		}
<<<<<<< HEAD
				}	    		
					
    			if ($lvgesamtnote = new lvgesamtnote($lvid,$row_stud->uid,$stsem))
    			{
    				$note_lv = $lvgesamtnote->note;
    			}
    			else
    				$note_lv = null;
				
				if (!is_null($note_lv))
					$note_vorschlag = $note_lv;
				else if ($le_anz > 0)
					$note_vorschlag = round($note_le/$le_anz);
=======
				}

    			if ($lvgesamtnote = new lvgesamtnote($lvid,$row_stud->uid,$stsem))
    			{
    				$note_lv = $lvgesamtnote->note;
					$punkte_lv = $lvgesamtnote->punkte;
    			}
    			else
				{
    				$note_lv = null;
					$punkte_lv = null;
				}

				$punkte_vorschlag='';
				if (!is_null($note_lv))
					$note_vorschlag = $note_lv;
				else if ($le_anz > 0)
				{
					if(CIS_GESAMTNOTE_PUNKTE)
					{
						$punkte_vorschlag = round($note_le/$le_anz,2);
						$notenschluessel = new notenschluessel();
						$note_vorschlag = $notenschluessel->getNote($punkte_vorschlag, $lvid, $stsem);
					}
					else
					{
						$note_vorschlag = round($note_le/$le_anz);
					}
				}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				else
					$note_vorschlag = null;
				if ($zeugnisnote = new zeugnisnote($lvid, $row_stud->uid, $stsem))
					$znote = $zeugnisnote->note;
				else
<<<<<<< HEAD
					$znote = null;			
								
				
				echo "<td>".$note_les_str."&nbsp;</td>";
				
				if (key_exists($row_stud->uid,$studpruef_arr))	
					$hide = "style='display:none;visibility:hidden;'";
				else
					$hide = "style='display:block;visibility:visible;'";				

				echo "<td valign='bottom' nowrap>
					<form name='$row_stud->uid' id='$row_stud->uid' method='POST' action='".$_SERVER['PHP_SELF']."?lvid=$lvid&lehreinheit_id=$lehreinheit_id&stsem=$stsem'>
						<span id='lvnoteneingabe_".$row_stud->uid."' ".$hide.">
							<input type='hidden' name='student_uid' value='$row_stud->uid'>";

				echo '<select name="note">';
				echo '<option value="">-- keine Auswahl --</option>';
				foreach($noten_obj->result as $row_note)
				{
					if($row_note->note == $note_vorschlag)
						$selected='selected';
					else
						$selected='';

					echo '<option value="'.$row_note->note.'" '.$selected.'>'.$row_note->bezeichnung.'</option>';

					//<input type='text' size='1' value='$note_vorschlag' name='note'>
				}
				echo '</select>';
				echo "
							<input type='hidden' name='note_orig' value='$note_lv'>
							<input type='button' value='->' onclick=\"saveLVNote('".$row_stud->uid."');\">
						</span>
					</form></td>";
				
					
				if ($note_lv == 5)
					$negmarkier = " style='color:red; font-weight:bold;'";
				else
					$negmarkier = "";			
				
				echo "<td align='center' id='note_$row_stud->uid'><span ".$negmarkier.">".(isset($noten_array[$note_lv])?$noten_array[$note_lv]:'')."</span></td>";
				
				//status //////////////////////////////////////////////////////////////////////////////////
				echo "<td align='center' id='status_$row_stud->uid'>";				
				if (!$lvgesamtnote->freigabedatum)
					echo "<img src='../../../../skin/images/offen.png'>";				
=======
					$znote = null;


				echo "<td style='white-space: nowrap;'>".$note_les_str."&nbsp;</td>";

				if (key_exists($row_stud->uid,$studpruef_arr))
					$hide = "style='display:none;visibility:hidden;'";
				else
					$hide = "style='display:block;visibility:visible;'";

				if(!defined('CIS_GESAMTNOTE_UEBERSCHREIBEN') || CIS_GESAMTNOTE_UEBERSCHREIBEN || (!CIS_GESAMTNOTE_UEBERSCHREIBEN && is_null($znote)))
				{
					echo "<td valign='bottom' nowrap>
						<form name='$row_stud->uid' id='$row_stud->uid' method='POST' action='".$_SERVER['PHP_SELF']."?lvid=$lvid&lehreinheit_id=$lehreinheit_id&stsem=$stsem'>
							<span id='lvnoteneingabe_".$row_stud->uid."' ".$hide.">
							<input type='hidden' name='student_uid' value='$row_stud->uid'>";

					// Punkte
					if(CIS_GESAMTNOTE_PUNKTE)
					{
						//$punkte_lv = $punkte_vorschlag;
						echo '<input type="text" name="punkte" id="textbox-punkte-'.$i.'" value="'.$punkte_vorschlag.'" size="3" oninput="PunkteEingabe('.$i.')"/>';
					}

					// Noten DropDown
					if($punkte_vorschlag!='' && CIS_GESAMTNOTE_PUNKTE)
						$disabled='disabled="disabled"';
					else
						$disabled='';
					echo '<select name="note" id="dropdown-note-'.$i.'" '.$disabled.'>';
					echo '<option value="">-- keine Auswahl --</option>';
					foreach($noten_obj->result as $row_note)
					{
						if($row_note->note == $note_vorschlag)
							$selected='selected';
						else
							$selected='';

						if($row_note->lehre && $row_note->aktiv)
							echo '<option value="'.$row_note->note.'" '.$selected.'>'.$row_note->bezeichnung.'</option>';
					}
					echo '</select>';
					echo "
								<input type='hidden' name='note_orig' value='$note_lv'>
								<input type='button' value='->' onclick=\"saveLVNote('".$row_stud->uid."');\">
							</span>
						</form></td>";
				}
				else
				{
					echo '<td></td>';
				}

				if(isset($noten_array[$note_lv]) && $noten_array[$note_lv]['positiv']==false)
					$negmarkier = " style='color:red; font-weight:bold;'";
				else
					$negmarkier = "";

				// LV Note
				echo '<td align="center" id="note_'.$row_stud->uid.'"><span '.$negmarkier.'>';
				if(isset($noten_array[$note_lv]))
					echo $noten_array[$note_lv]['bezeichnung'];
				if($punkte_lv!='')
					echo ' ('.number_format($punkte_lv,2).')';
				echo '</span></td>';

				//status
				echo "<td align='center' id='status_$row_stud->uid'>";
				if (!$lvgesamtnote->freigabedatum)
					echo "<img src='../../../../skin/images/offen.png'>";
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				else if	($lvgesamtnote->benotungsdatum > $lvgesamtnote->freigabedatum)
					echo "<img src='../../../../skin/images/changed.png'>";
				else
					echo "<img src='../../../../skin/images/ok.png'>";
<<<<<<< HEAD
					
				echo "</td>";
				if (($znote) and ($note_lv != $znote))
					$stylestr = " style='color:red; border-color:red; border-style:solid; border-width:1px;'";
				else
					$stylestr ="";
				echo "<td".$stylestr." align='center'>".(isset($noten_array[$znote])?$noten_array[$znote]:'')."</td>";
				if($znote==5 || $znote==7 || $znote==9 || $znote==13 || $znote==13 || $znote=='')
				{
					$summe_ng++;
				}
				// Pruefung 2.Termin ///////////////////////////////////////////////////////////////////////////
				if (key_exists($row_stud->uid, $studpruef_arr))			
=======

				echo "</td>";
				if (($znote) && ($note_lv != $znote))
					$stylestr = " style='color:red; border-color:red; border-style:solid; border-width:1px;'";
				else
					$stylestr ="";

				// Zeugnisnote
				echo "<td".$stylestr." align='center'>".(isset($noten_array[$znote])?$noten_array[$znote]['bezeichnung']:'')."</td>";

				if(isset($noten_array[$znote]) && $noten_array[$znote]['positiv']==false)
					$summe_ng++;

				// Pruefung 2.Termin
				if (key_exists($row_stud->uid, $studpruef_arr))
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				{
					echo "<td colspan='2'>";
					echo "<span id='span_".$row_stud->uid."'>";
					echo "<table>";
<<<<<<< HEAD
					$le_id_arr = array();					
					$le_id_arr = array_keys($studpruef_arr[$row_stud->uid]);
					foreach ($le_id_arr as $le_id_stud)
					{					
						$pr_note = $studpruef_arr[$row_stud->uid][$le_id_stud]["note"];
						$pr_datum = $studpruef_arr[$row_stud->uid][$le_id_stud]["datum"];
						$pr_le_id = $le_id_stud;
						
						echo "<tr><td class='td_datum'>";
						echo $pr_datum."</td><td class='td_note'>".$pr_note."</td><td>";
						echo "<input type='button' name='anlegen' value='".$p->t('global/aendern')."' onclick='pruefungAnlegen(\"".$row_stud->uid."\",\"".$pr_datum."\",\"".$pr_note."\",\"".$pr_le_id."\")'>";					
						echo "<td></tr>";
					}
					echo "</table>";			
					echo "</span>";
					//echo "<div id='nachpruefung_div_".$row_stud->uid."' style='position:relative; top:0px; left 5px; background-color:#cccccc; visibility:collapse;' class='transparent'></div>";
					echo "</td>";
					//echo "</form>";
				}
				else
				{
					if (!is_null($note_lv))				
						echo "<td colspan='2'><span id='span_".$row_stud->uid."'><input type='button' name='anlegen' value='".$p->t('benotungstool/anlegen')."' onclick='pruefungAnlegen(\"".$row_stud->uid."\",\"\",\"\",\"\")'></span></td>";
					else
						echo "<td colspan='2'></td>";	
				}
				// komm Pruefung ///////////////////////////////////////////////////////////////////////////
				if (key_exists($row_stud->uid,$studpruef_komm))			
=======
					$le_id_arr = array();
					$le_id_arr = array_keys($studpruef_arr[$row_stud->uid]);
					foreach ($le_id_arr as $le_id_stud)
					{
						$pr_note = $studpruef_arr[$row_stud->uid][$le_id_stud]["note"];
						$pr_punkte = $studpruef_arr[$row_stud->uid][$le_id_stud]["punkte"];
						$pr_datum = $studpruef_arr[$row_stud->uid][$le_id_stud]["datum"];
						$pr_le_id = $le_id_stud;

						if($pr_punkte!='')
							$pr_notenbezeichnung = $noten_array[$pr_note]['bezeichnung'].' ('.number_format($pr_punkte,2).')';
						else
							$pr_notenbezeichnung = $noten_array[$pr_note]['bezeichnung'];

						echo '<tr>
								<td class="td_datum">'.$pr_datum.'</td>
								<td class="td_note">'.$pr_notenbezeichnung.'</td>
								<td><input type="button" name="anlegen" value="'.$p->t('global/aendern').'" onclick="pruefungAnlegen(\''.$row_stud->uid.'\',\''.$pr_datum.'\',\''.$pr_note.'\',\''.$pr_le_id.'\',\''.$pr_punkte.'\')"><td>
							</tr>';
					}
					echo "</table>";
					echo "</span>";
					echo "</td>";
				}
				else
				{
					if (!is_null($note_lv) || !is_null($znote))
						echo "<td colspan='2'><span id='span_".$row_stud->uid."'><input type='button' name='anlegen' value='".$p->t('benotungstool/anlegen')."' onclick='pruefungAnlegen(\"".$row_stud->uid."\",\"\",\"\",\"\",\"\")'></span></td>";
					else
						echo "<td colspan='2'></td>";
				}

				// komm Pruefung
				if (key_exists($row_stud->uid,$studpruef_komm))
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				{
					echo "<td colspan='2'>";
					echo "<span id='span_".$row_stud->uid."'>";
					echo "<table>";
<<<<<<< HEAD
					$le_id_arr = array();					
					$le_id_arr = array_keys($studpruef_komm[$row_stud->uid]);
					foreach ($le_id_arr as $le_id_stud)
					{					
						$pr_note = $studpruef_komm[$row_stud->uid][$le_id_stud]["note"];
						$pr_datum = $studpruef_komm[$row_stud->uid][$le_id_stud]["datum"];
						$pr_le_id = $le_id_stud;
						
						echo "<tr><td class='td_datum'>";
						echo $pr_datum."</td><td class='td_note'>".$pr_note."</td>";
						//echo "<td><input type='button' name='anlegen' value='Ändern' onclick='pruefungAnlegen(\"".$row_stud->uid."\",\"".$pr_datum."\",\"".$pr_note."\",\"".$pr_le_id."\")'></td>";					
						echo "</tr>";
					}
					echo "</table>";			
					echo "</span>";
					//echo "<div id='nachpruefung_div_".$row_stud->uid."' style='position:relative; top:0px; left 5px; background-color:#cccccc; visibility:collapse;' class='transparent'></div>";
					echo "</td>";
					//echo "</form>";
				}
				else
				{
						echo "<td colspan='2'></td>";	
				}
				
=======
					$le_id_arr = array();
					$le_id_arr = array_keys($studpruef_komm[$row_stud->uid]);
					foreach ($le_id_arr as $le_id_stud)
					{
						$pr_note = $studpruef_komm[$row_stud->uid][$le_id_stud]["note"];
						$pr_punkte = $studpruef_komm[$row_stud->uid][$le_id_stud]["punkte"];
						$pr_datum = $studpruef_komm[$row_stud->uid][$le_id_stud]["datum"];
						$pr_le_id = $le_id_stud;

						if($pr_punkte!='')
							$pr_notenbezeichnung = $noten_array[$pr_note]['bezeichnung'].' ('.$pr_punkte.')';
						else
							$pr_notenbezeichnung = $noten_array[$pr_note]['bezeichnung'];

						echo '<tr>
								<td class="td_datum">'.$pr_datum.'</td>
								<td class="td_note">'.$pr_notenbezeichnung.'</td>
							</tr>';
					}
					echo "</table>";
					echo "</span>";
					echo "</td>";
				}
				else
				{
						echo "<td colspan='2'></td>";
				}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				echo "</tr>";
				$i++;
			}
		}
<<<<<<< HEAD
//	}
//}
echo "
<tr style='font-weight:bold;' align='center'>
<td class='ContentHeader2' style='font-weight:bold;'>&Sigma;</td>
<td class='ContentHeader2' style='font-weight:bold;' title='".$p->t('benotungstool/anzahlDerStudenten')."'>$summe_stud</td>
<td class='ContentHeader2' colspan='6'></td>
<td class='ContentHeader2' style='color:red; font-weight:bold;' title='".$p->t('benotungstool/anzahlNegativerBeurteilungen')."'>$summe_ng</td>
<td class='ContentHeader2' style='font-weight:bold;' colspan='2' title='".$p->t('benotungstool/anzahlNachpruefungen')."'>$summe_t2</td>
<td class='ContentHeader2' style='font-weight:bold;' colspan='2' title='".$p->t('benotungstool/anzahlKommisionellePruefungen')."'>$summe_komm</td>
</tr>
=======

// Fusszeile
echo "
	<tr style='font-weight:bold;' align='center'>
		<th style='font-weight:bold;'>&Sigma;</th>
		<th style='font-weight:bold;' title='".$p->t('benotungstool/anzahlDerStudenten')."'>$summe_stud</th>
		<th colspan='6'></td>
		<th style='color:red; font-weight:bold;' title='".$p->t('benotungstool/anzahlNegativerBeurteilungen')."'>$summe_ng</th>
		<th style='font-weight:bold;' colspan='2' title='".$p->t('benotungstool/anzahlNachpruefungen')."'>$summe_t2</th>
		<th style='font-weight:bold;' colspan='2' title='".$p->t('benotungstool/anzahlKommisionellePruefungen')."'>$summe_komm</th>
	</tr>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
</table>
</td></tr>

</table>
";
<<<<<<< HEAD
echo $htmlOutput;
?>

<div id="nachpruefung_div" style="position:absolute; top:100px; left:200px; width:400px; height:150px; background-color:#cccccc; visibility:hidden; border-style:solid; border-width:1px; border-color:#333333;" class="transparent"></div>
=======
?>

<div id="nachpruefung_div" style="position:absolute; top:100px; left:200px; width:400px; height:200px; background-color:#cccccc; visibility:hidden; border-style:solid; border-width:1px; border-color:#333333;" ></div>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

</body>
</html>
