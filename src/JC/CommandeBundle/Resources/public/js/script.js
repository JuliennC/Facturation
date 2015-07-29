	/* 
	*	Fonction pour enregistrer un paiement
	*/
function paiementCommande(idC){

	// On récupère le montant entré par l'utilisateur
	var montant = document.getElementById("inputMontant").value;

	var data = 'id='+idC+'&montant='+montant;

	// On envoie la requete	
	$.ajax({
		type: "get",
		url: Routing.generate('jc_commande_paiement_commande'),
		data: data,
		success: function(json){	
	   				
	   		if (json == true) {
				//On recharge la page
				location.reload();
			
			} else {
				alert("Erreur pendant le payement, veuillez re-essayer. "+json);	
			}
        }
    });    
}




/*
*	Fonction qui coche les checbox de la ville pass√©e en paramettre
*/
 function metVille(ventilation, nomColl, idColl, repartition){

 	console.log('remet '+ventilation);

 	if(ventilation == "Mutualisee"){
        
        //On marque le checkbox
        console.log('met ville : '+nomColl);

        //On recupere la ville selectionnee
		var checkbox = document.getElementById("jc_commandebundle_commande_villes_concernees_"+nomColl);
        //Dans les deux cas (mutualise et directe) on met check le checkbox
		checkbox.setAttribute('checked', 'checked');
        
	} else if(ventilation == "Directe"){
		
		//Si la commande était au parravant mutualisée
		//Et qu'on la change en directe, si une erreur dans le form, alors repartition sera
		//La clé de repartition de l'applicatoin (ce que l'on stock lorqu'une commande est mutualisées)
		if($.isNumeric(repartition)){
			document.getElementById('input_repartition_'+nomColl).setAttribute('value',repartition);
			document.getElementById('jc_commandebundle_commande_repartition'+idColl).setAttribute('value',repartition);
		}
		
	} else {
		alerte ("Erreur de ventilation.. ");
	}
	
}



/*
*	Fonction qui remet les valeurs en commande directe
*	d'un precedent formulaire (avec fautes)
*/
function remetValeur(nomColl, idColl){
	document.getElementById('input_repartition_'+nomColl).setAttribute('value',$('#jc_commandebundle_commande_repartition'+idColl).val());
	
}




	/* 
	*	Fonction appel√© lorsque l'utilisateur veut changer l'etat d'une commmande, 
	*	Elle envoie la requete et indique la r√©ponse
	*/
function changementEtatCommande(idC, etatC){

	if(etatC == "Payee" || etatC == "Desengager"){
		
		var data = 'id='+idC;
		
		if(etatC == "Payee"){
			
			 data += '&etat='+'Payee';

		} else if(etatC == "Desengager"){

			 data += '&etat='+'Enregistree';			
		}
		
		//On appelle la route qui va mettre la commande à payée
		$.ajax({
				type: "get",
				url: Routing.generate('jc_commande_change_etat'),
				data: data,
				success: function(json){	
	   				
	   				//On recharge la page
					location.reload();
	        }
	    });    
	
	
	} else {
		
		$(".hidden_etat").attr('value',etatC);

		$(".save").click();
		   
	}  
}
   


function setInfos(type, nom, adresse, complementAdresse, ville, codePostal, telephone, fax){
    
    console.log(type);
    document.getElementById('jc_commandebundle_commande_nom'+type).value = nom;
    document.getElementById('jc_commandebundle_commande_adresse'+type).value = adresse;
    document.getElementById('jc_commandebundle_commande_complementAdresse'+type).value = complementAdresse;
    document.getElementById('jc_commandebundle_commande_ville'+type).value = ville;
    document.getElementById('jc_commandebundle_commande_codePostal'+type).value = codePostal;
    document.getElementById('jc_commandebundle_commande_telephone'+type).value = telephone;
    document.getElementById('jc_commandebundle_commande_fax'+type).value = fax;
    
    $("#bouton_close_modal_"+type).click();
}
   
   
   
   
  
/*Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };*/


function calcul_TTC(id){
    
    var quantite = document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+id+'_quantite').value;
    var prix_unitaire = document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+id+'_prixUnitaire').value;

    var select = document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+id+'_tva');
    var pourcentage = select.options[select.selectedIndex].text;
    var p = pourcentage.replace("%", "");

    var total = (quantite * prix_unitaire * (1 + (p/100))).toFixed(2);

	//On affiche le total de la ligne
    var label_total = document.getElementById('total_TTC_'+id);
    label_total.innerHTML = total+"€";
    
    //On marque (dans le champs caché du formulaire) le total de la ligne
    document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+id+'_totalTTC').value = total;

	calculTotauxCommande();

}  




/*
*	Fonction qui calcule le total HT et TTC d'une commande
*/
function calculTotauxCommande(){

	//on récupère toutes les lignes commandes
	var listeLignesCommande = document.getElementsByClassName("ligne_commande");
	
	var totalHT = 0;
	var totalTTC = 0;
	
	for (var i = 0, len = listeLignesCommande.length; i < len; i++) {
		
		var ligne = listeLignesCommande[i];

		var quantite = ligne.getElementsByClassName("quantite")[0].value;
		var prixUnitaire = ligne.getElementsByClassName("prixUnitaire")[0].value;
		var select = ligne.getElementsByClassName("tva")[0];
		var tva = select.options[select.selectedIndex].text;
		var pourcentage = tva.replace("%", "");

		totalHT = parseFloat(totalHT) + parseFloat((quantite * prixUnitaire).toFixed(2));
		totalTTC = parseFloat(totalTTC) + parseFloat(((quantite * prixUnitaire) * (1 + (pourcentage/100))).toFixed(2));
		
		console.log('Ligne : '+i+" : "+totalHT);		
		console.log('Ligne : '+i+" : "+totalTTC);		

	}
	
	
	

	//On marque le total de la commande HT
    document.getElementById('total_commande_HT').textContent = totalHT;

	//On marque le total de la commande TTC
    document.getElementById('total_commande_TTC').textContent = totalTTC;
                //parseFloat
};




	

/*
*	Fonction pour supprimer une ligne d'une commande
*/
function supprimerLigneCommande(numero){

		//Pour récupérer la ligne, on passe par un champs du form, puis on récupère son td puis son tr
		var ligne = document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+numero+'_libelle').parentNode.parentNode;

	  	ligne.remove();
                
};



function metEnPlaceVentilation(ventil){
	if(ventil.indexOf('Directe')>-1) { $('#boutonDirecte').click();}
	else if(ventil.indexOf('Mutualisee')>-1){ $('#boutonMutualisee').click();}
	else {alert("Erreur de ventilation.. '"+ventil+"'");}
}



/*
*	jQuery
*/
$(document).ready(function() {
	
	
	/*
	*	Fonction qui permet de rentrer les contacts du fournisseur
	*/
	
	$("#boutonContactFournisseur").on("click", function(){
	
		//On supprime le bouton
		$("#boutonContactFournisseur").remove();
		
		//On affiche les champs
		$("#cacheContactFournisseur").attr('style','');
		
	});
	
	
	/*
	*	Fonction pour supprimer une ligne d'une commande
	*/
	
	$(".supprimer_ligne_commande").on('click', function(){
      	
     
	  	$(this).parent().parent().remove();
               
	});
	
   
   /*
	*	Fonction pour ajouter une ligne à une commande
	*/
    $("#ajouter_ligne_commande").on('click', function(){
      	
      	// Dans le contenu de l'attribut ¬´ data-prototype ¬ª, on remplace :
	  	// - le texte "__name__label__" qu'il contient par le label du champ
	  	// - le texte "__name__" qu'il contient par le num√©ro du champ
	  	
	  	var tableL = $("#tbody_corps");
                //On fait -1 car il y a la ligne du bouton "ajouter"
	  	var index = (tableL.find('tr').length)-1;
	  	
	 

        // parcourt le template prototype
        //var newLigne = $("#jc_commandebundle_commande_lignesCommande").attr('data-prototype');
           
    
    
    var newLigne =	 	"<td>"+
	    					"<a onclick='supprimerLigneCommande(__name__);'>"+
	    						"<span class='glyphicon glyphicon-remove-circle'>"+
								"</span>"+
	    					"</a>"+
						"</td>"+
						
						"<td>"+
							"<textarea id='jc_commandebundle_commande_listeLignesCommande___name___libelle' name='jc_commandebundle_commande[listeLignesCommande][__name__][libelle]' required='required' class='col-md-12'> </textarea>"+ 
						"</td>"+
						
						"<td>"+
							"<textarea id='jc_commandebundle_commande_listeLignesCommande___name___commentaire' name='jc_commandebundle_commande[listeLignesCommande][__name__][commentaire]' class='col-md-12'> </textarea>"+
						"</td>"+
						
						"<td>"+
							"<input type='text' id='jc_commandebundle_commande_listeLignesCommande___name___reference' name='jc_commandebundle_commande[listeLignesCommande][__name__][reference]' required='required'	class='col-md-12'>"+
						"</td>"+
						
						"<td>"+ 
							"<input type='text' onkeyup='calcul_TTC(__name__);' id='jc_commandebundle_commande_listeLignesCommande___name___quantite' name='jc_commandebundle_commande[listeLignesCommande][__name__][quantite]' required='required' class='col-md-12 quantite'>"+ 
						"</td>"+
						
						"<td>"+
							"<input type='text' onkeyup='calcul_TTC(__name__);'  id='jc_commandebundle_commande_listeLignesCommande___name___prixUnitaire' name='jc_commandebundle_commande[listeLignesCommande][__name__][prixUnitaire]' required='required' class='col-md-11 prixUnitaire'> €"+
						"</td>"+
							
						"<td>"+
						 	"<select onchange='calcul_TTC(__name__);' id='jc_commandebundle_commande_listeLignesCommande___name___tva' name='jc_commandebundle_commande[listeLignesCommande][__name__][tva]' class='col-md-12 tva'>";
						 	
						 	//On va chercher les taux de TVA dans la base
						 	
						 	//	On dit √† ajax d'√™tre synchrone
						 	//	Inconv√©niant --> Si la requ√™te est lente, la nouvelle ligne mettra du temps √† s'afficher
						 	//	Avantage --> On est sur qu'il y aura les bon % de TVA dans les choix
						 	$.ajaxSetup({async: false});
						 	
						 	$.ajax({
						        type: "get",
						        url: Routing.generate('jc_commande_get_tva'),
						        success: function(json){						
						   			
						   			if( json.length === 0) {
							   			alert("Une erreur s'est produite, veuillez r√©essayer");
										
										//On remet la valeur par d√©faut
										$.ajaxSetup({async: true});
								        
								        return false;


						   			} else {
							   			
							           $.each(json, function(index, value){

									   		newLigne += "<option value='"+value['id']+"'>"+value['pourcentage']+"%</option>"
							
										})
									
									
										newLigne += "</select>"+
													"</td>"+
													
													"<td>"+
														"<span class='col-md-11 col-md-offset-1' id='total_TTC___name__' value='0.00 Ä'></span>"+
													"</td>"+ 
                                                                                                
                                                                                                            "<input type='hidden' id='jc_commandebundle_commande_listeLignesCommande___name___totalTTC' name='jc_commandebundle_commande[listeLignesCommande][__name__][totalTTC]' value='0.00' />"
                                                                                                        ;
							      	
							      	
							     
							      	
								      	// remplace les "__name__" utilis√©s dans l'id 
								        // par un nombre unique 
								        newLigne = newLigne.replace(/__name__/g, index);
								        
								        // cr√©er une nouvelle liste d'√©l√©ments et l'ajoute √† notre liste
								        var newLi = jQuery('<tr class="ligne_commande"></tr>').html(newLigne);
								        $('#ligne_totaux').before(newLi);
								        
								        //	On remet la valeur par d√©faut
										$.ajaxSetup({async: true});
										
								        return false;

									}
						        }
						    });    
						 	

						 	
						 	
						 	
						 	
						

  });
   



	/* 
	*	Fonction utilis√© dans la cr√©ation et la modification d'une commande, 
	*	Elle g√®re l'affichage des villes suivant le choix "mutualis√©e" ou "directe"
	*/
	$('#select-ventilation a').click(function(){

		if( $(this).attr("id") == 'boutonDirecte'){
			
			//On affiche les bouton en consequence
			$('#boutonDirecte').attr('class', 'btn btn-success col-md-4 col-md-offset-2');
			$('#boutonMutualisee').attr('class', 'btn noActive col-md-4');

			//On met l'attribut ventilation
			$(".hidden_ventilation").attr('value','Directe');						
			
			//On affiche les input
			$(".contientInput").show();
			
			//On cache les checkbox 
			$('.contientCheck').hide();
			

						
			//On cache et on affiche
			//$("#form_villes_mutualisees").hide();
			
		} else if( $(this).attr("id") == 'boutonMutualisee'){
			
			//On met les boutons en consequence
			$('#boutonDirecte').attr('class', 'btn noActive col-md-4 col-md-offset-2');
			$('#boutonMutualisee').attr('class', 'btn btn-success col-md-4');		
			
			//On met la valeur de ventilation
			$(".hidden_ventilation").attr('value','Mutualisee');
			
			//On chache les input
			$(".contientInput").hide();
			
			//On remet le checkbox visible
			$('.contientCheck').show();
			
			


		}

	});


	




	/*
	* Lorsque l'on clique sur un bouton d'une ville l'imput correspondant se focus, 
	*/
	$(".btn_input_repartition").on('click',function() {

		var input = $(this).attr('for');
		$('#'+input).focus();
	});





	$('.contientInput input').on('keyup',function(){
		
		//On recupere la ville concernee
		var villeConcernee = $(this).attr('for');
		
		//On met à jour le champs cache concerne
		var hidden = $('input[attr_nom_ville="'+villeConcernee+'"]');

        //On sauvegarde la repartition
		hidden.attr('value', $(this).val());
		
		console.log(hidden);
	});
	
	

	

	/*
	* Lorsque l'on choisi une activite, 
	* la liste des applications devient la liste des applications 
	* en lien avec l'activite
	*/
	$(".choix_activite r").change(function() {

		var nomActivite = $( ".choix_activite option:selected").getNom();

	
		var DATA = 'act=' + nomActivite;
	
		$.ajax({
	        type: "get",
	        url: "applicationPourActivite",
	        data: DATA,
	        success: function(json){
	
				$('.choix_application').find('option').remove();
	
	   			
	           $.each(json, function(index, value){
			   
			   		alert(value[0]);
				   	$(".choix_application").append('<option valuse="'+ value.nom+'">'+ value.nom+'</option>');
	
				})
	
	        }
	    });    

	}); 
	
	
});




