/* Copyright (C) 2013 fhcomplete.org
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
 * Authors: Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at>,
 *			Stefan Puraner	<puraner@technikum-wien.at>
 */
var studiengang_kz='';
var studiengang_bezeichnung='';
var studienordnung_id='';
var studienordnung_bezeichnung='';
var studienplan_id='';
var lehrveranstaltungen='';

// Speichert die Parameter des aktuell angezeigten Studienplans fuer Refresh des Trees
var loadLehrveranstaltungSTPLStudienplan_id = '';
var loadLehrveranstaltungSTPLBezeichnung = '';
var loadLehrveranstaltungSTPLSemester = '';

// Wenn true sind die LV Filter bereits geladen und muessen nicht erneut geladen werden
var isLVFilterLoaded=false;

/**
 * Error-Behandlung bei Ajax Requests
 */
<<<<<<< HEAD
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
function loadError(xhr, textStatus, errorThrown)
{
	if(xhr.status==200)
		alert('Fehler:'+xhr.responseText);
	else
		alert('Fehler beim Laden der Daten. ErrorNr:'+xhr.status);
}

/**
 * Entfernt Null Werte
 */
function ClearNull(value)
{
	if(value===null)
		return '';
	else
		return value;
}

/**
 * Schreibt die Ueberschrift des angezeigten Studienplanes
 */
function drawHeader(text)
{
	if(text===undefined)
	{
		text = '<h2>';
		if(studiengang_bezeichnung!='')
			text=text+studiengang_bezeichnung;
		if(studienordnung_bezeichnung!='')
			text=text+' <b>&gt;</b> '+studienordnung_bezeichnung;
		if(studienplan_bezeichnung!='')
			text=text+' <b>&gt;</b> '+studienplan_bezeichnung;


		text=text+'</h2>';
	}
	else
		text='<h2>'+text+'</h2>';
	$('#header').html(text);
}

/**
 * Laedt die Studienordnungen und zeigt diese im linken Menue an
 */
function loadStudienordnung()
{
<<<<<<< HEAD
=======
	var method = 'loadStudienordnungSTGInaktiv';
	if(typeof initSTOs === 'undefined')
	{
		method = 'loadStudienordnungSTG';
	}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	// Ausgewaehlten Studiengang holen
	studiengang_kz = $('#studiengang').val();
	studiengang_bezeichnung = $( "#studiengang option:selected" ).text();

	// Globale Variablen resetten
	studienordnung_id='';
	studienordnung_bezeichnung='';
	studienplan_id='';
	studienplan_bezeichnung='';

	drawHeader();

	// Laden der Studienordnungen
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		data: {
				"typ": "json",
				"class": "studienordnung",
<<<<<<< HEAD
				"method":	"loadStudienordnungSTG",
=======
				"method":	method,
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				"parameter_0": studiengang_kz
			},
		error: loadError
	}).success(function(data)
	{
		if(data.error=='true')
		{
			alert('Fehler:'+data.errormsg);
		}
		else
		{
			$("#studienplan").html("Bitte wählen Sie zuerst eine Studienordnung aus!");
			drawStudienordnungen(data.result);
			//jqUi( "#menueLinks" ).accordion("option","active",1);
		}
	});
}

/**
 * Erstellt die Links fuer die Studienordnungen
 * @param data Objekt mit den Studienordnungsdaten
 */
function drawStudienordnungen(data)
{
	var obj='<a href="#Neu" onclick="neueStudienordnung();return false;">Neue Studienordnung</a><ul style="padding-left: 15px">';

	for(i in data)
	{
		if(data[i].studienordnung_id !== null)
		{
<<<<<<< HEAD
			obj=obj+'<li><a href="#Load'+data[i].studienordnung_id+'" onclick="loadStudienplanSTO('+data[i].studienordnung_id+',\''+data[i].bezeichnung+'\');return false;">'+data[i].bezeichnung+'</a>'
				+' <a href="#Edit'+data[i].studienordnung_id+'" onclick="editStudienordnung('+data[i].studienordnung_id+');return false;"><img title="Bearbeiten" src="../../skin/images/edit.png"></a>'
				+' <a href="#Copy'+data[i].studienordnung_id+'" onclick="copyStudienordnung('+data[i].studienordnung_id+');return false;"><img title="Studienordnung kopieren" src="../../skin/images/copy.png"></a></li>';
=======
			obj=obj+'<li><a style="white-space:nowrap" href="#Load'+data[i].studienordnung_id+'" onclick="loadStudienplanSTO('+data[i].studienordnung_id+',\''+data[i].bezeichnung+'\');return false;">'+data[i].bezeichnung+'</a>'
				+' <a href="#Edit'+data[i].studienordnung_id+'" onclick="editStudienordnung('+data[i].studienordnung_id+');return false;"><img title="Bearbeiten" src="../../skin/images/edit.png"></a>'
				+' <a href="#Copy'+data[i].studienordnung_id+'" onclick="copyStudienordnung('+data[i].studienordnung_id+');return false;"><img title="Studienordnung kopieren" src="../../skin/images/copy.png"></a>&nbsp;&nbsp;&nbsp;'
				+' <a href="../../content/pdfExport.php?xml=studienordnung.rdf.php&xsl=Studienordnung&studienordnung_id='+data[i].studienordnung_id+'&stg_kz=0&output=doc"><img style="cursor:pointer; height: 16px;" title="Studienordnung als Word-Dokument exportieren" src="../../skin/images/doc_icon.png"></a>'
				+' <a href="../../content/pdfExport.php?xml=studienordnung.rdf.php&xsl=Studienordnung&studienordnung_id='+data[i].studienordnung_id+'&stg_kz=0&output=pdf"><img style="cursor:pointer; height: 16px;" title="Studienordnung als PDF-Dokument exportieren" src="../../skin/images/pdf_icon.png"></a></li>';
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}
	}
	obj=obj+'</ul>';
	$("#data").empty();
	$("#tabs").hide();
	$('#studienordnung').html(obj);
}

/**
 * Laedt die Studienplaene zu einer Studienordnung
 */
function loadStudienplanSTO(neue_studienordnung_id,bezeichnung)
{
	studienordnung_bezeichnung=bezeichnung;
	studienordnung_id=neue_studienordnung_id;
	drawHeader();
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		data: {
				"typ": "json",
				"class": "studienplan",
				"method":	"loadStudienplanSTO",
				"parameter_0": studienordnung_id
			},
		error: loadError
	}).success(function(data)
	{
		if(data.error=='true')
		{
			alert('Fehler:'+data.errormsg);
		}
		else
		{
			drawStudienplan(data.result);
			//jqUi( "#menueLinks" ).accordion("option","active",2);
		}
		semesterStoZuordnung();
	});
	$.ajax({
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		data: {
			"typ" : "json",
			"class": "studienordnung",
			"method": "loadStudienordnung",
			"parameter_0": studienordnung_id
		},
		error: loadError
	}).success(function(data){
		if(data.result.length === 1)
		{
			var html = "";
			html += data.result[0];
		}
	});
}

/**
 * Erstellt die Links zu den Studienplaenen
 */
function drawStudienplan(data)
{
	var obj='<a href="#Neu" onclick="neuerStudienplan();return false;">Neuer Studienplan</a><ul  style="padding-left: 15px">';

	for(i in data)
	{
		if(data[i].studienplan_id !== null)
		{
			obj=obj+'<li><a href="#Load'+data[i].studienplan_id+'" onclick="loadLehrveranstaltungSTPL('+data[i].studienplan_id+',\''+data[i].bezeichnung+'\',\''+data[i].regelstudiendauer+'\');return false;">'+data[i].bezeichnung+'</a>'
			+' <a href="#Edit'+data[i].studienplan_id+'" onclick="editStudienplan('+data[i].studienplan_id+');return false;"><img title="edit" src="../../skin/images/edit.png"></a></li>';
		}
	}
	obj=obj+'</ul>';
	$("#tabs").hide();
	$('#studienplan').html(obj);
}

/**
 * Konvertiert den Tree fuer den Studienplan damit dieser mit jstree angezeigt werden kann
 */
function GenerateTreeChilds(data)
{
	var children = [];
	if(data.children!==undefined)
	{
		// Rekursiv die darunterliegenden LVs aufloesen
		for(i in data.children)
			children.push(GenerateTreeChilds(data.children[i]));
	}
	var obj = {
	"data":data.bezeichnung,
	"metadata":	{"lehrveranstaltung_id":data.lehrveranstaltung_id,"bezeichnung":data.bezeichnung,"ects":data.ects,"semesterstunden":data.semesterstunden,"lehrform_kurzbz":data.lehrform_kurzbz,"lvnr":data.lvnr,"sortierung":data.stpllv_sort},
	"attr":{"id":data.studienplan_lehrveranstaltung_id,"rel":data.lehrtyp_kurzbz,"lvID":data.lehrveranstaltung_id,"studienplan_lehrveranstaltung_id":data.studienplan_lehrveranstaltung_id},
	"children":children
	};
	return obj;
}

/**
 * Laedt die Lehrveranstaltungen eines Studienplanes
 */
function loadLehrveranstaltungSTPL(studienplan_id, bezeichnung, max_semester)
{
	// Daten in globale Variable Speichern damit der Tree spaeter refresht werden kann
	loadLehrveranstaltungSTPLStudienplan_id = studienplan_id;
	loadLehrveranstaltungSTPLBezeichnung = bezeichnung;
	loadLehrveranstaltungSTPLSemester = max_semester;

	//studienplan_id = studienplan_id;
	studienplan_bezeichnung=bezeichnung;
	drawHeader();

	// Laden der Daten
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		data: {
				"typ": "json",
				"class": "lehrveranstaltung",
				"method": "getLvTree",
				"parameter_0": studienplan_id,
			},
		error: loadError
	}).success(function(data)
	{

		// Daten konvertieren damit diese im Tree angezeigt werden koennen
		var treeData=[];
		var semester=max_semester;

		// Semester Baum aufbauen

		// 0er Semester direkt anzeigen (als uebergeordnete LVs)
		var children = [];
		for(i in data.return)
		{
			var item = data.return[i];
			if(item.stpllv_semester==0)
			{
				treeData.push(GenerateTreeChilds(item));
			}
		}

		// Alle anderen Semester durchlaufen
		for(var sem=1;sem<=semester;sem++)
		{
			// LVs die direkt unter diesem Semester liegen
			var children = [];
			for(i in data.return)
			{
				var item = data.return[i];
				if(item.stpllv_semester==sem)
				{
					children.push(GenerateTreeChilds(item));
				}
			}
			// Sortieren nach der Bezeichnung
			children.sort(function(a,b){
				return a.data>b.data;
			});
			var obj = {
			"data":sem+'. Semester',
			"attr":{"id":"Semester"+sem,"rel":"semester","semester":sem},
			"children":children
			};
			treeData.push(obj);
		}

<<<<<<< HEAD
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		// DIV fuer den Tree neu anlegen damit der alte Tree vollstaendig entfernt wird
		$("#data").html("<div id='treeData'></div>");

		function searchChildren(element, matchingId, original)
		{
			var found = false;
			$("#"+element.attr("id")+" ul").first().children().each(function(i,v){
				if($(v).attr("lvid") === original.attr("id"))
				{
					found = true;
				}
			});
			if((found) || ($("#"+element.attr("id")).attr("lvid") === matchingId))
			{
				if(($("#"+element.attr("id")).find("[lvid='"+matchingId+"']").attr("id") === original.attr("id")) || ($("#"+element.attr("id")).attr("id") === original.attr("id")))
				{
					return false;
				}
				return true;
<<<<<<< HEAD
			}		
=======
			}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			return false;
		}

		function searchParents(element, matchingId)
		{
			if((element.parent().parent().attr("lvid") === matchingId) || (element.attr("lvid") === matchingId))
			{
				return true;
			}
			else
			{
				if(element.parent().parent().attr("lvid") !== undefined)
				{
					if(searchParents(element.parent().parent(), matchingId))
						return true;
				}
				return false;
			}
		}

		// Anzeigen des Trees mit den Lehrveranstaltungen
		$("#treeData").jstree({
				ui: {
					"select_limit": 1,
					"select_multiple_modifier": "ctrl"
				},
<<<<<<< HEAD
				json_data: { 
=======
				json_data: {
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					data: treeData // Daten an den Tree binden
				},
				crrm: {
					move: {
						"always_copy": "multitree",
						"check_move": function(m) {
							var text;
							if(m.ot === m.rt)
							{
								if((searchChildren(m.r, m.o.attr("lvid"), m.o) === true) || (searchParents(m.r, m.o.attr("lvid")) === true))
								{
									return false;
								}
							}
							else
							{
								if((searchChildren(m.r, m.o.attr("id"), m.o) === true) || (searchParents(m.r, m.o.attr("id")) === true))
								{
									return false;
								}
							}
<<<<<<< HEAD
							
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
							if(m.o.attr("rel")==="semester")
							{
								return false;
							}
							if(m.r.attr("rel")==="semester" && (m.p === "inside" || m.p === "before"))
							{
								return true;
							}
							if(m.p === "inside" || m.p === "last")
							{
								return true;
							}

							return false;
						}
					}
				},
				dnd: {
					"drag_check": function(data){
						return {
							after: false,
							before: false,
							inside: true
						};
					}
				},
				grid: {
					columns: [
						{width: 300, header: "Lehrveranstaltung", value: "bezeichnung", source: "metadata", headerClass: "header_lv"},
						{width: 50, header: "ECTS", value: "ects", source: "metadata", wideCellClass: "col_ects", headerClass: "header_ects"},
						{width: 120, header: "Semesterstunden", value: "semesterstunden", source: "metadata", cellClass: "col_semesterstunden"},
						{width: 80, header: "Lehrform", value: "lehrform_kurzbz", source: "metadata", cellClass: "col_lehrform"},
						{width: 80, header: "LVNR", value: "lvnr", source: "metadata", cellClass: "col_lvnr"},
						{width: 80, header: "Sortierung", value: "sortierung", source: "metadata", cellClass: "col_sortierung"},
					],
					resizable: true
				},
				types: {
					"types" :  {
						"lv" : {
							icon : {
								image : "../../skin/images/lv.png"
							}
						},
						"semester" : {

						},
						"modul" : {
							icon : {
								image : "../../skin/images/modul.png"
							}
						},
						"lf" : {
						}
					}
				},
				sort : function(a, b){
					return this._get_node(a).attr("rel") > this._get_node(b).attr("rel");
				},
				contextmenu: {
					// Kontextmenue
					"items" : function(node) {
						// Loeschen nur anzeigen wenn Eintrag kein Semester ist
						if(node.attr("rel") !== "semester")
						{
							return {
								"Delete" : {
									"label" : "Eintrag entfernen",
									"action": function(obj){
<<<<<<< HEAD
										// Pruefen ob LVs unterhalb dieser LV haengen, 
=======
										// Pruefen ob LVs unterhalb dieser LV haengen,
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
										// falls ja wird das loeschen verhindert
										if(obj.children().find("li").length === 0)
										{
											var conf = confirm("Wollen Sie \""+this.get_text(obj)+"\" wirklich aus diesem Studienplan löschen?");
											if(conf)
											{
												deleteLehrveranstaltungFromStudienplan(obj.attr("studienplan_lehrveranstaltung_id"), this, obj);
											}
										}
										else
										{
											alert("Das zu löschende Element darf keine Elemente beinhalten!");
										}
									}
								}
							};
						}
<<<<<<< HEAD
						
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					}
				},
				plugins: ["themes", "ui", "dnd", "grid", "json_data", "crrm", "types", "sort", "contextmenu"]
			}).bind("move_node.jstree", function(event, data)
			{
//				if(searchTree(data.rslt.r, data.rslt.o.attr("id")))
//				{
//					$("#treeData").jstree("remove", "#"+data.rslt.oc.attr("id"));
//					alert("Lehrveranstaltung bereits vorhanden");
//				}
//				else
//				{
					// Verschieben eines Eintrages

<<<<<<< HEAD
					// Studienplan_lehrveranstaltung_id ermitteln	
					var studienplan_lehrveranstaltung_id='';
					if(data.rslt.o[0].attributes.studienplan_lehrveranstaltung_id)
						studienplan_lehrveranstaltung_id=data.rslt.o[0].attributes.studienplan_lehrveranstaltung_id.value;
=======
					// Studienplan_lehrveranstaltung_id ermitteln
					var studienplan_lehrveranstaltung_id='';
					if(data.rslt.o[0].attributes.studienplan_lehrveranstaltung_id){
						studienplan_lehrveranstaltung_id=data.rslt.o[0].attributes.studienplan_lehrveranstaltung_id.value;
						//$("#treeData").jstree('refresh');
					}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

					// Aenderung speichern
					saveJsondataFromTree(data.rslt.o[0].id, studienplan_id, studienplan_lehrveranstaltung_id);

<<<<<<< HEAD
					// ECTS Summen neu berechnen				
=======
					// ECTS Summen neu berechnen
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					var root = data.inst.get_container_ul();
					var nodes = root[0].childNodes;
					for(var i=0; i<nodes.length; i++)
					{
						if(nodes[i].getAttribute("rel") === "semester")
						{
							writeEctsSum(nodes[i]);
						}

					}
					hideAllTreeColumns();
					writeOverallSum(nodes);
//				}
			}).bind("loaded.jstree", function(event, data)
			{
				// Wenn der Tree geladen wird, die ECTS Summen der einzelnen Semester berechnen
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				var root = data.inst.get_container_ul();
				var nodes = root[0].childNodes;
				for(var i=0; i<nodes.length; i++)
				{
					if(nodes[i].getAttribute("rel") === "semester"){
						writeEctsSum(nodes[i]);
					}
<<<<<<< HEAD
					
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				}
				writeOverallSum(nodes);
			}).bind("open_node.jstree", function(event, data)
			{
				if(data.args[0].attr)
				{
					var root = data.inst.get_container_ul()[0].childNodes;
					var nodes = $("#"+data.args[0].attr("id"));

					for(var i=0; i<nodes.length; i++)
					{
						if(nodes[i].getAttribute("rel") === "semester"){
							writeEctsSum(nodes[i]);
						}
					}
					writeOverallSum(root);
				}
			}).bind("select_node.jstree", function(event, data)
			{
				// Bei einem Klick auf eine LV werden die Details geladen
				stpllvid = data.rslt.obj.attr("studienplan_lehrveranstaltung_id");
				lvid = data.rslt.obj.attr("lvID");
				if(lvid !== undefined)
				{
					if(lvid.substring(0,5)==="copy_")
					{
						lvid = lvid.substring(5);
					}
				}
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694

				// Lehrveranstaltungsdetails laden
				if(data.rslt.obj.attr("rel") !== "semester")
				{
					LoadLVDetails(lvid, stpllvid);
				}
				else
				{
					$("#tab-lehrveranstaltungdetail").html("<p>Klicken Sie auf eine Lehrveranstaltung um die Details anzuzeigen</p>");
				}
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				// Regeln laden
				if(data.rslt.obj.attr("rel") !== "semester")
				{
					if(stpllvid!==undefined)
						LVRegelnloadRegeln(stpllvid);
				}
				else
				{
					$("#tab-regel").html("<p>Klicken Sie auf eine Lehrveranstaltung um die Regeln anzuzeigen</p>");
				}
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				// Kompatibilitaet laden
				if(data.rslt.obj.attr("rel") !== "semester")
				{
					if(lvid!==undefined)
						loadLVKompatibilitaet(lvid);
				}
				else
				{
					$("#tab-kompatibel").html("<p>Klicken Sie auf eine Lehrveranstaltung um die kompatiblen Lehrveranstaltungen anzuzeigen</p>");
				}
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				// Sortierung laden
				if(data.rslt.obj.attr("rel") !== "semester")
				{
					if(lvid!==undefined)
						loadSTPLSortierung(stpllvid);
				}
				else
				{
					$("#tab-sortierung").html("<p>Klicken Sie auf eine Lehrveranstaltung um die Sortierung innerhalb der Studienplanansicht im CIS zu ändern.</p>");
				}
		});

		if(!isLVFilterLoaded)
		{
			$("#lehrveranstaltung").html("OE: <div id='oeDiv' style='display:inline'></div><br><br>");
			$.ajax(
			{
				dataType: "json",
				url: "../../soap/fhcomplete.php",
				data: {
						"typ": "json",
						"class": "organisationseinheit",
						"method": "getAll",
						"parameter_0":true,
						"parameter_1":true
					},
				error: loadError
			}).success(function(data)
			{
				var html = "<select id='oeDropdown' style='max-width: 200px' onchange='loadFilteredLehrveranstaltungen();'><option value=''>-- Keine --</option>";
				for(i in data.result)
				{
					if(data.result[i].aktiv===true)
					{
						html+='<option value="'+data.result[i].oe_kurzbz+'">'+data.result[i].organisationseinheittyp_kurzbz+' '+data.result[i].bezeichnung+'</option>';
					}
				}
				html+="</select>";
				$("#oeDiv").html(html);
				loadLehrtypen();
			});
		}
		else
		{
			// Filter sind bereits vorhanden, nur die LVs und Semesteranzahl werden neu geladen
			loadSemester();
		}
	});
	$( "#tabs" ).show();
<<<<<<< HEAD
=======


>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}

/**
 * Laedt Details zur ausgewaehlten Lehrveranstaltung
 */
function LoadLVDetails(lvid, stpllvid)
{
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		data: {
				"typ": "json",
				"class": "lehrveranstaltung",
				"method": "load",
				"parameter_0":lvid
			},
		error: loadError
	}).success(function(data)
	{
		lvdata = data.result[0];
		var html = "<b>"+ClearNull(lvdata.bezeichnung)+" - "+ClearNull(lvdata.kurzbz)+"</b>";
		html+="<br>ECTS: "+ClearNull(lvdata.ects);
		html+="<br>Semesterstunden: "+ClearNull(lvdata.semesterstunden);
		html+="<br>LVNR: "+ClearNull(lvdata.lvnr);
		html+="<br>Lehrform: "+ClearNull(lvdata.lehrform_kurzbz);
		html+="<br>LV-Semester: "+ClearNull(lvdata.semester);
		html+="<br><br>LVID: "+ClearNull(lvdata.lehrveranstaltung_id)+" / StgKz: "+ClearNull(lvdata.studiengang_kz);
		$("#tab-lehrveranstaltungdetail").html(html);
<<<<<<< HEAD
	});	
=======
	});
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}

/**
 * Laedt kompatible LVs zur ausgewaehlten Lehrveranstaltung
 */
function loadLVKompatibilitaet(lvid)
{
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		data: {
				"typ": "json",
				"class": "lehrveranstaltung",
				"method": "getLVkompatibel",
				"parameter_0":lvid
			},
		error: loadError
	}).success(function(data)
	{
		var html='';
		for(i in data.result)
		{
			if(data.result[i])
			{
				lvdata = data.result[i];
				if(!(lvdata.kurzbz===null && lvdata.bezeichnung===null && lvdata.studiengang_kz===null && lvdata.semester===null))
					html = html+'<br>'+lvdata.kurzbz+' - '+lvdata.bezeichnung+' (Studiengang '+lvdata.studiengang_kz+', Semester '+lvdata.semester+')';
			}
			html = html+'<br><br><a href="lehrveranstaltung_kompatibel.php?lehrveranstaltung_id='+lvid+'&type=edit" target="_blank">kompatible Lehrveranstaltungen hinzufügen</a>';
		}
		$("#tab-kompatibel").html(html);
<<<<<<< HEAD
		
	});	
=======

	});
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}
/*
 * lädt die Sortierung einer Lehrveranstaltung innerhalb eines Studienplans
 * @param {type} lvid
 * @returns {undefined}
 */
function loadSTPLSortierung(stpllvid)
{
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		data: {
				"typ": "json",
				"class": "studienplan",
				"method": "loadStudienplanLehrveranstaltung",
				"parameter_0":stpllvid
			},
		error: loadError
	}).success(function(data)
	{
		var html='';
		for(i in data.result)
		{
			if(data.result[i])
			{
				lvdata = data.result[i];
				html += 'Sortierung: <input type="number" id="stplSort" value="'+ClearNull(lvdata.sort)+'"><br/><input type="button" onclick="saveSortierung(\''+stpllvid+'\');" value="Speichern">';
			}
		}
		$("#tab-sortierung").html(html);
	});
}

function saveSortierung(stpllvid)
{
	var sort = $('#stplSort').val();
	if(sort === "")
		sort=null;
	savedata = {
		"studienplan_lehrveranstaltung_id": stpllvid,
		"sort": sort
	};
	$.ajax(
<<<<<<< HEAD
	{	
=======
	{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		type: "POST",
		data: {
			"typ": "json",
			"class": "studienplan",
			"method": "saveSortierung",
			"savedata": JSON.stringify(savedata)
		}
	}).success(function(d)
	{
		//console.log(d);
	});
}


/**
 * Laedt die Daten um eine neue Studienordnung zu erstellen
 */
function neueStudienordnung()
{
	$("#tabs").hide();
	drawHeader('Neue Studienordnung');
	$("#data").load('studienordnung.inc.php?method=neueStudienordnung&studiengang_kz='+studiengang_kz);
}

/**
 * Laedt die Daten um einen neuen Studienplan zu erstellen
 */
function neuerStudienplan()
{
	$("#tabs").hide();
	drawHeader('Neuer Studienplan');
	$("#data").load('studienordnung.inc.php?method=neuerStudienplan&studiengang_kz='+studiengang_kz);
}

/**
 * Laedt die Daten um eine Studienordnung zu editieren
 */
function editStudienordnung(studienordnung_id)
{
	$("#tabs").hide();
	drawHeader('Studienordnung bearbeiten');
	$("#data").load('studienordnung.inc.php?method=neueStudienordnung&studiengang_kz='+studiengang_kz+'&studienordnung_id='+studienordnung_id);
}

/**
 * Laedt die Daten um einen Studienplan zu editieren
 */
function editStudienplan(studienplan_id)
{
	$("#tabs").hide();
	drawHeader('Studienplan bearbeiten');
	$("#data").load('studienordnung.inc.php?method=neuerStudienplan&studiengang_kz='+studiengang_kz+'&studienplan_id='+studienplan_id);
}

/*
<<<<<<< HEAD
* Funktion zum Laden des Baumes der 
=======
* Funktion zum Laden des Baumes der
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
* gefilterten LVs
* */
function loadFilteredLehrveranstaltungen()
{
	if($("#oeDropdown option:selected").val() === "")
	{
<<<<<<< HEAD
		$.ajax(	
=======
		$.ajax(
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			dataType: "json",
			url: "../../soap/fhcomplete.php",
			data: {
					"typ": "json",
					"class": "lehrveranstaltung",
					"method":	"load_lva",
					"parameter_0": studiengang_kz,						//Studiengangskennzahl
					"parameter_1": $("#semesterDropdown").val(),		//Semester
					"parameter_2": "null",								//Lehrverzeichnis
					"parameter_3": "null",								//Lehre // sollte TRUE sein
					"parameter_4": "true",								//Aktiv // sollte TRUE sein
					"parameter_5": "bezeichnung",						//Sortierung
					"parameter_6": "null",								//$("#oeDropdown option:selected").val(),//Organisationseinheit KurzBz
					"parameter_7": $("#lehrtypDropdown option:selected").val()			//Lehrtyp KurzBz
				},
			error: loadError
		}).success(function(data)
		{
			showLVTree(data);
		});
	}
	else
	{
		//get LVs by OE
		$.ajax(
		{
			dataType: "json",
			url: "../../soap/fhcomplete.php",
			data: {
					"typ": "json",
					"class": "lehrveranstaltung",
					"method":	"load_lva_oe",
					"parameter_0": $("#oeDropdown option:selected").val(),			//Organisationseinheit KurzBz
					"parameter_1": "true",											//Aktiv // sollte TRUE sein
					"parameter_2": $("#lehrtypDropdown option:selected").val(),		//Lehrtyp KurzBz
					"parameter_3": "null",											//optionale Sortierung
					"parameter_4": $("#semesterDropdown option:selected").val()		//Semester
				},
			error: loadError
		}).success(function(data)
		{
			showLVTree(data);
		});
	}
}

function showLVTree(data)
{
	if(data.result[0].lehrveranstaltung_id!==null)
	{

		var TreeData = []
		for(i in data.result)
		{
			item = data.result[i];
			var obj = {
			"data":item.bezeichnung,
			"metadata":	{"lehrveranstaltung_id":item.lehrveranstaltung_id,"bezeichnung":item.bezeichnung,"ects":item.ects,"semesterstunden":item.semesterstunden,"lvnr":item.lvnr,"lehrform_kurzbz":item.lehrform_kurzbz},
			"attr":{"id":item.lehrveranstaltung_id,"rel":item.lehrtyp_kurzbz,"lvID":item.lehrveranstaltung_id,"studienplan_lehrveranstaltung_id":item.studienplanlehrveranstaltung_id},
			};
			TreeData.push(obj);
		}

		if($("#lvListe").length === 0)
		{
			$("#filteredLVs").html("<h3></h3><div id='lvListe'></div>");
<<<<<<< HEAD
		} 
		else 
=======
		}
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$("#filteredLVs").html("<h3>Daten werden geladen...</h3><div id='lvListe'></div>");
		}
		$("#lvListe").jstree({
			ui: {
				"select_limit": 1,
				"select_multiple_modifier": "ctrl"
			},
<<<<<<< HEAD
			json_data: { 
=======

			json_data: {
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				data: TreeData,
				progressive_render : true
			},
			crrm: {
				move: {
					"check_move" : function(m)
					{
						return false;
					},
					"always_copy": "multitree"
				}
			},
			types: {
				"types" :  {
					"lv" : {
						icon : {
							image : "../../skin/images/lv.png"
						}
					},
					"modul" : {
						icon : {
							image : "../../skin/images/modul.png"
						}
					},
					"lf" : {
					}
				}
			},
			grid: {
				columns: [
					{width: 250, header: "Lehrveranstaltung", value: "bezeichnung", source: "metadata"},
					{width: 50, header: "ECTS", value: "ects", source: "metadata"},
					{width: 80, header: "Lehrform", value: "lehrform_kurzbz", source: "metadata"},
					{width: 100, header: "LVNR", value: "lvnr", source: "metadata"}
					//{width: 80, header: "Semester", value: "semester", source: "metadata"},
					//{width: 120, header: "Semesterstunden", value: "semesterstunden", source: "metadata"},
				],
				resizable: true
			},
			plugins: ["themes", "ui", "dnd", "grid", "json_data", "crrm", "types", "sort"]
<<<<<<< HEAD
		}).bind("loaded.jstree", function(event, data) 
		{
			$("#loadingGif").remove();
			$("h3:contains('Daten werden geladen...')").remove();
=======
		}).bind("loaded.jstree", function(event, data)
		{
			$("#loadingGif").remove();
			$("h3:contains('Daten werden geladen...')").remove();
			$("#filteredLVs").height("auto");
			$("#menueRechts").height("auto");
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			//hideAllTreeColumns();
		}).bind("select_node.jstree", function(event, data)
		{
			// Bei einem Klick auf eine LV werden die Details geladen
			lvid = data.rslt.obj.attr("lvID");
<<<<<<< HEAD
			
			
			LoadLVDetails(lvid, null);
			
			// Regeln laden
			$("#tab-regel").html("<p>Regeln werden nur angezeigt wenn die LV im Studienplan hängt</p>");
			
=======


			LoadLVDetails(lvid, null);

			// Regeln laden
			$("#tab-regel").html("<p>Regeln werden nur angezeigt wenn die LV im Studienplan hängt</p>");

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			// Kompatibilitaet laden
			if(lvid!==undefined)
				loadLVKompatibilitaet(lvid);

<<<<<<< HEAD
		});
	} 
	else 
=======
		}).bind("move_node.jstree", function(event, data)
		{
			var studienplan_lehrveranstaltung_id='';
			if(data.rslt.o[0].attributes.studienplan_lehrveranstaltung_id){
				studienplan_lehrveranstaltung_id=data.rslt.o[0].attributes.studienplan_lehrveranstaltung_id.value;
				$("#treeData").jstree.refresh();
			}

			// Aenderung speichern
			saveJsondataFromTree(data.rslt.o[0].id, studienplan_id, studienplan_lehrveranstaltung_id);

			// ECTS Summen neu berechnen

			hideAllTreeColumns();
			writeOverallSum(nodes);
		});
	}
	else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	{
		$("#filteredLVs .jstree-grid-wrapper").remove();
		if($("#lvListe").length !== 0)
		{
			$("#lvListe").remove();
		}
		$("h3:contains('')").remove();
		$("#filteredLVs").append("<div id='lvListe'>Keine Einträge gefunden!</div>");
	}
<<<<<<< HEAD
=======
	/*$("#filteredLVs").css(
		max-width, $("#divLVuebersicht").width()
	);*/
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}

/*
* Funktion zum Laden der Daten für
* das Dropdownfeld zum Filtern nach Lehrtyp
*/
function loadLehrtypen()
{
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
		data: {
				"typ": "json",
				"class": "lehrtyp",
				"method": "getAll"
			},
		error: loadError
	}).success(function(data)
	{
		if($("#lehrtypenDiv").length === 0)
		{
			$("#lehrveranstaltung").append("Lehrtyp: <div id='lehrtypenDiv' style='display:inline'></div><br><br>");
		}
		var html = "<select id='lehrtypDropdown' onchange='loadFilteredLehrveranstaltungen();'><option value='null'>-- Alle --</option>";
		for(i in data.result)
		{
			html+='<option value="'+data.result[i].lehrtyp_kurzbz+'">'+data.result[i].bezeichnung+'</option>';
		}
		html+="</select>";
		$("#lehrtypenDiv").html(html);
		loadSemester();
	});
}

/*
* Funktion zum Laden der Daten für
* das Dropdownfeld zum Filtern nach Semester
*/
function loadSemester()
{
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/studienplan.json.php",
		data: {
				"method": "getSemesterFromStudiengang",
				"studiengang_kz": studiengang_kz
			},
		error: loadError
	}).success(function(data)
	{
		if($("#semesterListe").length === 0)
		{
			$("#lehrveranstaltung").append("Semester: <div id='semesterListe'  style='display:inline'></div><br>");
		}
		var html = "<select id='semesterDropdown' onchange='loadFilteredLehrveranstaltungen();'>";
		html += "<option value='null'>-- Alle --</option>";
		var semesterselected=false;
		var selected='';
		for(i in data.result)
		{
			// Der erste Eintrag im Drop Down wird markiert da sonst alle Semester geladen werden
			// was in manchen Studiengaengen sehr lange dauern kann
			if(!semesterselected)
			{
				selected='selected';
				semesterselected=true;
			}
			else
				selected='';
			html+="<option value='"+data.result[i]+"' "+selected+">"+data.result[i]+". Semester</option>";
		}
		html+="</select>";
		$("#semesterListe").html(html);
<<<<<<< HEAD
=======
		if($("#neueLV").length === 0)
			$("#lehrveranstaltung").append("<div id='neueLV'></div>");

		$("#neueLV").html("<br/><a href='./lehrveranstaltung_details.php?neu=true&stg_kz="+studiengang_kz+"' target='_blank'><input type='button' value='Neue LV anlegen'></a>");
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		isLVFilterLoaded=true;
		loadFilteredLehrveranstaltungen();
	});
}

/**
 * Funktion zum Verstecken der Spalten im Baum der
 * gefilterten LV-Liste
 */
function hideAllTreeColumns()
{
	var headers = $("#filteredLVs .jstree-grid-header-cell");
	var separators = $("#filteredLVs .jstree-grid-separator");
	//separators[0].style.display = "none";
	for(var j=4; j<headers.length; j++)
	{
		headers[j].style.display = "none";
		separators[j].style.display = "none";
		var divs = $("#filteredLVs .jstree-grid-col-" + j);
		for (var i = 0; i < divs.length; i++)
		{
<<<<<<< HEAD
			divs[i].style.display = "none";	
=======
			divs[i].style.display = "none";
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}
	}
}

/**
 * Speichert einen Datensatz der in den LV Tree gezogen wurde
 * @param nodeId ID des Eintrages der gedroppt wurde
 * @param studienplan_id ID des Studienplanes
 * @param studienplan_lehrveranstaltung_id wird nur bei verschiebungen uebergeben
 */
function saveJsondataFromTree(nodeId, studienplan_id, studienplan_lehrveranstaltung_id)
{
	var jsonData=Array();

	// Wenn eine verschiebung innerhalb des Studienplans stattfindet wird der Eintrag aus dem Tree geholt
	if(studienplan_lehrveranstaltung_id!='')
	{
		jsonData = $("#treeData").jstree("get_json", $("#treeData").find("li[id="+nodeId+"]"));
	}
	var copy = false;

	// Wenn die Lehrveranstaltung aus dem Lehrveranstaltungstree kommt ist diese mit copy_ geprefixt
	if(jsonData.length !== 1)
	{
		jsonData = $("#treeData").jstree("get_json", $("#copy_"+nodeId));
		copy = true;
	}
	loaddata = {
		"method" : "loadStudienplanLehrveranstaltung",
		"parameter_0" : studienplan_lehrveranstaltung_id
	};

	var node;
	if(copy)
	{
		node = $("#copy_"+jsonData[0]["metadata"]["lehrveranstaltung_id"]);
	}
	else
	{
		node = $("#"+studienplan_lehrveranstaltung_id);
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	var lehrveranstaltung_id = jsonData[0]["metadata"]["lehrveranstaltung_id"];
	var semester = node.closest("li[rel=semester]").attr("semester");

	// Wenn die Lehrveranstaltung ausserhalb des Semester platziert wird, werden diese ins 0er Semester gelegt
	if(semester === undefined)
	{
		semester = 0;
	}

	var parent_id ='';
	if(node.parent().parent().attr("studienplan_lehrveranstaltung_id"))
		parent_id = node.parent().parent().attr("studienplan_lehrveranstaltung_id");

	var neu = true;
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	if(studienplan_lehrveranstaltung_id !== undefined && studienplan_lehrveranstaltung_id!='')
		neu = false;

	// Bei neuen Eintraegen kein Load noetig
	if(neu)
		loaddata='';
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	savedata = {
		"studienplan_id": studienplan_id,
		"lehrveranstaltung_id" : lehrveranstaltung_id,
		"semester": semester,
		"studienplan_lehrveranstaltung_id_parent": parent_id,
		"pflicht": true
	};
<<<<<<< HEAD
	
	$.ajax(
	{	
		dataType: "json",
		url: "../../soap/fhcomplete.php",
=======

	$.ajax(
	{
		dataType: "json",
		url: "./saveStudienordnung.php",
		//url: "../../soap/fhcomplete.php",
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		type: "POST",
		data: {
			"typ": "json",
			"class": "studienplan",
			"method": "saveStudienplanLehrveranstaltung",
			"loaddata": JSON.stringify(loaddata),
			"savedata": JSON.stringify(savedata)
		},
		error: TreeSaveError
	}).success(function(d)
	{
		if(d.error!==undefined && d.error=='false')
		{
			node.attr("studienplan_lehrveranstaltung_id", d.result[0].studienplan_lehrveranstaltung_id);
			node.attr("id", d.result[0].studienplan_lehrveranstaltung_id);
			$("#jsonData").html(d);
		}
		else
		{
			alert('Fehler:'+d.errormsg);
			$("#treeData").jstree("remove", node);
		}
	});
}

/**
 * Wird aufgerufen wenn ein Fehler beim Speichern der TreeZuteilung passiert
 * Dabei wird der ganze Tree neu geladen
 */
function TreeSaveError(xhr, textStatus, errorThrown)
{
	if(xhr.status==200)
	{
		alert('Fehler:'+xhr.responseText);
	}
	else
		alert('Fehler beim Laden der Daten. ErrorNr:'+xhr.status);

	// Studienplan Tree neu Laden um inkonsistente Anzeigen zu verhindern
<<<<<<< HEAD
	loadLehrveranstaltungSTPL(loadLehrveranstaltungSTPLStudienplan_id, loadLehrveranstaltungSTPLBezeichnung, loadLehrveranstaltungSTPLSemester);	
=======
	loadLehrveranstaltungSTPL(loadLehrveranstaltungSTPLStudienplan_id, loadLehrveranstaltungSTPLBezeichnung, loadLehrveranstaltungSTPLSemester);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}

/**
 * Entfernt eine LV Zuordnung
 */
function deleteLehrveranstaltungFromStudienplan(lehrveranstaltung_studienplan_id, tree, obj)
{
	$.ajax({
		dataType: "json",
<<<<<<< HEAD
		url: "../../soap/fhcomplete.php",
=======
		url: "./saveStudienordnung.php",
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		type: "POST",
		data: {
			"typ": "json",
			"class": "lvregel",
			"method": "exists",
			"parameter_0": lehrveranstaltung_studienplan_id
		},
		error: loadError
	}).success(function(data){
		if(data.return === false)
		{
			$.ajax({
				dataType: "json",
<<<<<<< HEAD
				url: "../../soap/fhcomplete.php",
=======
				url: "./saveStudienordnung.php",
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				type: "POST",
				data: {
					"typ": "json",
					"class": "studienplan",
					"method": "deleteStudienplanLehrveranstaltung",
					"parameter_0" : lehrveranstaltung_studienplan_id
				},
				error: loadError
			}).success(function(data)
			{
				if(data.error==true)
				{
					alert('Fehler beim Entfernen:'+data.errormsg);
				}
				else
				{
					tree.remove(obj);
				}
			});
		}
		else
		{
			alert("Es müssen zuerst die LV-Regeln gelöscht werden.");
		}
	});
}

/**
 * Speichert die Studienordnung
 */
function saveStudienordnung()
{
	bezeichnung = $("#bezeichnung").val();
	version = $("#version").val();
	gueltigvon = $("#gueltigvon option:selected").val();
	gueltigbis = $("#gueltigbis option:selected").val();
	ects = $("#ects").val();
	studiengangbezeichnung = $("#studiengangbezeichnung").val();
	studiengangbezeichnungenglisch = $("#studiengangbezeichnungenglisch").val();
	studiengangkurzbzlang = $("#studiengangkurzbzlang").val();
	mystudienordnung_id = $("#studienordnung_id").val();
	akadgrad_id = $("#akadgrad_id").val();

	if(mystudienordnung_id!='')
	{
		loaddata = {
			"method": "loadStudienordnung",
			"parameter_0": mystudienordnung_id
		};
	}
	else
		loaddata={};

	savedata = {
		"bezeichnung": bezeichnung,
		"version":version,
		"gueltigvon":gueltigvon,
		"gueltigbis":gueltigbis,
		"ects":ects,
		"studiengangbezeichnung":studiengangbezeichnung,
		"studiengangbezeichnung_englisch":studiengangbezeichnungenglisch,
		"studiengangkurzbzlang":studiengangkurzbzlang,
		"akadgrad_id":akadgrad_id,
		"studiengang_kz":studiengang_kz
	};

<<<<<<< HEAD
	
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
=======

	$.ajax(
	{
		dataType: "json",
		url: "./saveStudienordnung.php",
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		type: "POST",
		data: {
				"typ": "json",
				"class": "studienordnung",
				"method": "save",
				"loaddata": JSON.stringify(loaddata),
				"savedata": JSON.stringify(savedata),
			},
		success: function(data){
			if(data.error=='true')
				alert('Fehler:'+data.errormsg);
			else
			{
				$("#submsg").css("visibility", "visible");
				window.setTimeout(function(){$("#submsg").css("visibility", "hidden");}, 1500);
				loadStudienordnung();
			}
		},
		error: loadError
	});
}

/**
 * Speichert den Studienplan
 */
function saveStudienplan()
{
	bezeichnung = $("#bezeichnung").val();
	version = $("#version").val();
	orgform_kurzbz = $("#orgform_kurzbz option:selected").val();
	sprache = $("#sprache option:selected").val();
	regelstudiendauer = $("#regelstudiendauer").val();
	semesterwochen = $("#semesterwochen").val();
	testtool_sprachwahl = $("#testtool_sprachwahl").prop("checked");
	aktiv = $("#aktiv").prop("checked");
	mystudienplan_id = $("#studienplan_id").val();

	if(mystudienplan_id!='')
	{
		loaddata = {
			"method": "loadStudienplan",
			"parameter_0": mystudienplan_id
		};
	}
	else
		loaddata={};

	savedata = {
	"bezeichnung": bezeichnung,
	"version":version,
	"orgform_kurzbz":orgform_kurzbz,
	"sprache":sprache,
	"regelstudiendauer":regelstudiendauer,
	"semesterwochen":semesterwochen,
	"testtool_sprachwahl":testtool_sprachwahl,
	"aktiv":aktiv,
	"studienordnung_id":studienordnung_id
	};

<<<<<<< HEAD
	
	$.ajax(
	{
		dataType: "json",
		url: "../../soap/fhcomplete.php",
=======

	$.ajax(
	{
		dataType: "json",
		url: "./saveStudienordnung.php",
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		type: "POST",
		data: {
				"typ": "json",
				"class": "studienplan",
				"method": "save",
				"loaddata": JSON.stringify(loaddata),
				"savedata": JSON.stringify(savedata)
			},
		success: function(data){
			if(data.error=='true')
				alert('Fehler:'+data.errormsg);
			else
			{
				$("#submsg").css("visibility", "visible");
				window.setTimeout(function(){$("#submsg").css("visibility", "hidden");}, 1500);
<<<<<<< HEAD
				loadStudienplanSTO(studienordnung_id,studienordnung_bezeichnung);	
=======
				loadStudienplanSTO(studienordnung_id,studienordnung_bezeichnung);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			}
		},
		error: loadError
	});
}

/**
 * Berechnet dei ECTS Summe fuer ein Semester / Modul
 */
function writeEctsSum(parent)
{
	for(var i=0; i<$(parent).children("ul").children().length; i++)
	{
		if($(parent).children("ul").children().length > 0)
		{
			writeEctsSum($(parent).children("ul").children()[i]);
<<<<<<< HEAD
		}	
=======
		}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	}
	if($(parent).attr("rel") === "semester")
	{
		var cells = $(parent).find(".jstree-grid-col-1");
		var sum = 0;
		for(var j=1; j<cells.length; j++)
		{
			if(!isNaN(parseFloat(cells[j].childNodes[0].innerHTML)))
			{
				sum+=parseFloat(cells[j].childNodes[0].innerHTML);
			}
		}
		cells[0].childNodes[0].innerHTML = "<b>"+sum+"</b>";
	}
}

/**
 * Berechnet die ECTS Gesamt summe
 */
function writeOverallSum(root)
{
<<<<<<< HEAD
	$("#treeData").append('<div id="stplDetails" style="padding-top: 1.0em"></div>');
=======
	if(!$('#stplDetails').length)
		$("#treeData").append('<div id="stplDetails" style="padding-top: 1.0em"></div>');
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	var cells = $(root).find(".jstree-grid-col-1");
	var sum = 0;

	for(var i=0; i<cells.length; i++)
	{
		if(!isNaN(parseFloat(cells[i].childNodes[0].innerHTML)))
		{
			sum+=parseFloat(cells[i].childNodes[0].innerHTML);
		}
	}
	$("#stplDetails").html("ECTS-Summe: <b>"+sum+"</b>");
	$("#stplDetails").show();
}

/**
 * Laedt die Daten zum Eintragen der Studienordnung/Semester zuordnung
 */
function semesterStoZuordnung()
{
	drawHeader('Neue Semester Zuordnung');
	$("#data").load('studienordnung.inc.php?method=semesterStoZuordnung&studienordnung_id='+studienordnung_id);
}

/**
 * Speichert die Studienordnung/Semester zuordnung
 */
function saveSemesterStoZuordnung(studiensemester, ausbildungssemester)
{
	if(studiensemester == undefined &&  ausbildungssemester == undefined)
	{
		var sem = $("#studiensemester").val();
		var cells = $("#studiensemester").parents().closest("tr").find("input[type=checkbox]");
		var semester = new Array();
		var semesterKurzbz = "";

		for(var i = 0; i < cells.length; i++)
		{
			//semester[cells[i].getAttribute("semester")] = cells[i].checked;
			semester.push(cells[i].checked);
		}

		var studiensemester = $("#studiensemester").val();
		for(var j=0; j<semester.length; j++)
		{
			if(semester[j] === true)
			{
				$.ajax({
					dataType: "json",
					url: "../../soap/studienordnung.json.php",
					type: "POST",
					data: {
						"method": "saveSemesterZuordnung",
						"studienordnung_id": studienordnung_id,
						"studiensemester_kurzbz" : studiensemester,
						"ausbildungssemester": j+1
					}
				}).success(function(data)
				{
					if(data.error === "true")
					{
						alert(data.errormsg);
					}
					semesterStoZuordnung();
				});
			}
		}
	}
	else
	{
		$.ajax({
			dataType: "json",
			url: "../../soap/studienordnung.json.php",
			type: "POST",
			data: {
				"method": "saveSemesterZuordnung",
				"studienordnung_id": studienordnung_id,
				"studiensemester_kurzbz" : studiensemester,
				"ausbildungssemester": ausbildungssemester
			}
		}).success(function(data)
		{
			if(data.error === "true")
			{
				alert(data.errormsg);
			}
			semesterStoZuordnung();
		});
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}

function deleteSemesterZuordnung(ausbildungssemester_kurzbz, studiensemester)
{
	if(studiensemester == undefined)
	{
		var row = $("#row_"+ausbildungssemester_kurzbz);
		$.ajax({
			dataType: "json",
<<<<<<< HEAD
			url: "../../soap/fhcomplete.php",
=======
			url: "./saveStudienordnung.php",
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			type: "POST",
			data: {
				"typ":"json",
				"class" : "studienordnung",
				"method": "deleteSemesterZuordnung",
				"parameter_0": studienordnung_id,
				"parameter_1" : ausbildungssemester_kurzbz
			}
		}).success(function(data)
		{
			semesterStoZuordnung();
		});
	}
	else
	{
		$.ajax({
			dataType: "json",
<<<<<<< HEAD
			url: "../../soap/fhcomplete.php",
=======
			url: "./saveStudienordnung.php",
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			type: "POST",
			data: {
				"typ":"json",
				"class" : "studienordnung",
				"method": "deleteSemesterZuordnung",
				"parameter_0": studienordnung_id,
				"parameter_1" : ausbildungssemester_kurzbz,
				"parameter_2" : studiensemester
			}
		}).success(function(data)
		{
			semesterStoZuordnung();
		});
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
}

/**
 * Kopiert eine Studienordnung
 * @param studienordnung_id
 */
function copyStudienordnung(studienordnung_id)
{
	if(confirm("Wollen Sie diese Studienordnung wirklich kopieren?"))
	{
		$.ajax({
			dataType: "json",
			url: "../../soap/studienordnung.json.php",
			type: "POST",
			data: {
				"method": "copyStudienordnung",
				"studienordnung_id": studienordnung_id
			},
			error: loadError
		}).success(function(data)
		{
			if(data.error === "true")
			{
				alert(data.errormsg);
			}
			loadStudienordnung();
<<<<<<< HEAD
		});		
=======
		});
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	}
}
