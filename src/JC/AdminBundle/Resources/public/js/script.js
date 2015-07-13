/*
*	jQuery
*/

$(document).ready(function() {
  
	/*
	*	Fonction qui pour ajouter une collectivite
	*/
  $("#ajouter_collectivite").on('click', function(){
      	
      	// Dans le contenu de l'attribut ¬´ data-prototype ¬ª, on remplace :
	  	// - le texte "__name__label__" qu'il contient par le label du champ
	  	// - le texte "__name__" qu'il contient par le num√©ro du champ
	  	
	  	var tableL = $("#body_collectivite");
                
        //On fait -1 car il y a la ligne du bouton "ajouter"
	  	var index = (tableL.find('tr').length)-1;
	  	
	  	
	 

        // parcourt le template prototype
        //var newLigne = $("#jc_commandebundle_commande_lignesCommande").attr('data-prototype');
           
    
   
    var newLigne = "<tr>"
	    				+"<td>"
	     					+"<input type='text' id='jc_commandebundle_listecollectivites_listeCollectivites___name___nom' 																								name='jc_commandebundle_listecollectivites[listeCollectivites][__name__][nom]' required=''required'>"
	     				+"</td>"
						
						+"<td>"
						+"<input type='text' id='jc_commandebundle_listecollectivites_listeCollectivites___name___dateDebutMutualisation' 																				name='jc_commandebundle_listecollectivites[listeCollectivites][__name__][dateDebutMutualisation]' required='required'																	class='datepicker hasDatepicker'/>"
						+"</td>"
								
						+"<td>" 
							+"<input type='text' id='jc_commandebundle_listecollectivites_listeCollectivites___name___dateFinMutualisation' 																					name='jc_commandebundle_listecollectivites[listeCollectivites][__name__][dateFinMutualisation]' required='required' 																	class='datepicker hasDatepicker'>"
						+"</td>"
					+"</tr>";
										
						 	
								      	// remplace les "__name__" utilis√©s dans l'id 
								        // par un nombre unique 
								        newLigne = newLigne.replace(/__name__/g, index);
								        
								        // cr√©er une nouvelle liste d'√©l√©ments et l'ajoute √† notre liste
								        $('#last_tr_collectivites').before(newLigne);
								        
								     
								        return false;

									
						        
	});    
	
	
	/*
	*	Fonction pour ajoute une clé de répartition
	*/
	$("#ajouter_cle_repartition").on('click', function(){
      	
      	// Dans le contenu de l'attribut ¬´ data-prototype ¬ª, on remplace :
	  	// - le texte "__name__label__" qu'il contient par le label du champ
	  	// - le texte "__name__" qu'il contient par le num√©ro du champ
	  	
	  	var tableL = $("#body_cle_repartition");
                
        //On fait -1 car il y a la ligne du bouton "ajouter"
	  	var index = (tableL.find('tr').length)-1;
	  	
	  	
	 

        // parcourt le template prototype
        //var newLigne = $("#jc_commandebundle_commande_lignesCommande").attr('data-prototype');
           
    
   
    var newLigne = "<tr>"			  	
			
						+"<td>" 
							+"<input type='text' id='jc_commandebundle_listeclesrepartition_listeClesRepartition___name___nom' 																							name='jc_commandebundle_listeclesrepartition[listeClesRepartition][__name__][nom]' required='required' maxlength='255' class='col-md-8 col-md-offset-2' 								/>" 
						+"</td>"
									
					+"</tr>"
										
						 	
					// remplace les "__name__" utilis√©s dans l'id 
					// par un nombre unique 
					newLigne = newLigne.replace(/__name__/g, index);
								        
			        // cr√©er une nouvelle liste d'√©l√©ments et l'ajoute √† notre liste
			        $('#last_tr_cle_repartition').before(newLigne);
								        
								     
			        return false;

									
						        
	    });    
	
	
	
	
	/*
	*	Fonction pour ajouter un utilisateur
	*/
	
	$("#ajouter_utilisateur").on('click', function(){
      	
      	// Dans le contenu de l'attribut ¬´ data-prototype ¬ª, on remplace :
	  	// - le texte "__name__label__" qu'il contient par le label du champ
	  	// - le texte "__name__" qu'il contient par le num√©ro du champ
	  	
	  	var tableL = $("#body_utilisateur");
                
        //On fait -1 car il y a la ligne du bouton "ajouter"
	  	var index = (tableL.find('tr').length)-1;
	  	
	  	
	 
	  	//On doit récupérer les options du select du service
	  	// Pour cela, on récupère les options du premier utilisateur(en partant du principe qu'il y a au moins 1 utilisateur ....)
	  	var strOptions = "";
	  	//On récupère la ligne du premier utilisateur
	  	var tr = tableL.find("tr:first");
	 
	  	//On va chercher son select, et on parcours les options
	  	tr.find("select:first option").each(function() {
									
			//On créé un string que l'on ajoutera au moment voulu
			strOptions += "<option value='"+$(this).val()+"'>";
			strOptions += $(this).text();
			strOptions += "</option>";

		});
								
        
           
    
   
    var newLigne = 	"<tr>"
						+"<td></td>"
						+"<td>" 
							+"<input type='text' id='jc_commandebundle_listeutilisateurs_listeUtilisateurs___name___nom' name='jc_commandebundle_listeutilisateurs[listeUtilisateurs][__name__][nom]' required='required' maxlength='255'>" 
						+"</td>"
								
						+"<td>" 
							+"<input type='text' id='jc_commandebundle_listeutilisateurs_listeUtilisateurs___name___prenom' name='jc_commandebundle_listeutilisateurs[listeUtilisateurs][__name__][prenom]' required='required' maxlength=255'>" 
						+"</td>"

						+"<td>" 
							+"<select id='jc_commandebundle_listeutilisateurs_listeUtilisateurs___name___service' name='jc_commandebundle_listeutilisateurs[listeUtilisateurs][__name__][service]'>"
		
								+strOptions
								
							+"</select>" 
						+"</td>"
					+"</tr>";
										
						 	
		// remplace les "__name__" utilis√©s dans l'id 
        // par un nombre unique 
        newLigne = newLigne.replace(/__name__/g, index);
								        
        // cr√©er une nouvelle liste d'√©l√©ments et l'ajoute √† notre liste
        $('#last_tr_utilisateur').before(newLigne);
								        
								     
        return false;				
						        
		});    
						 	


		
		
		
	/*
	*	Fonction pour ajouter un utilisateur
	*/
	
	$(".supprimer_utilisateur").on('click', function(){
      	
      	// Dans le contenu de l'attribut ¬´ data-prototype ¬ª, on remplace :
	  	// - le texte "__name__label__" qu'il contient par le label du champ
	  	// - le texte "__name__" qu'il contient par le num√©ro du champ
	  	
	  	$(this).parent().parent().remove();
                
  

		});





	/*
	*	Fonction pour ajouter un utilisateur
	*/
	
	$("#ajouter_service").on('click', function(){
      	
      	// Dans le contenu de l'attribut ¬´ data-prototype ¬ª, on remplace :
	  	// - le texte "__name__label__" qu'il contient par le label du champ
	  	// - le texte "__name__" qu'il contient par le num√©ro du champ
	  	
	  	var tableL = $("#body_service");
                
        //On fait -1 car il y a la ligne du bouton "ajouter"
	  	var index = (tableL.find('tr').length)-1;
	  	
	  	
	  	
    var newLigne = 	"<tr>"
						  	
						+"<td>" 
							+"<input type='text' id='jc_commandebundle_listeservices_listeServices___name___nom' name='jc_commandebundle_listeservices[listeServices][__name__][nom]' 											required='required'>" 
						+"</td>"
						
						+"<td>" 
							+"<input type='checkbox' id='jc_commandebundle_listeservices_listeServices___name___estAncienService'																					name='jc_commandebundle_listeservices[listeServices][__name__][estAncienService]' >" 
						+"</td>"
										
					+"</tr>";
										
						 	
		// remplace les "__name__" utilis√©s dans l'id 
        // par un nombre unique 
        newLigne = newLigne.replace(/__name__/g, index);
								        
        // cr√©er une nouvelle liste d'√©l√©ments et l'ajoute √† notre liste
        $('#last_tr_service').before(newLigne);
								        
								     
        return false;				
						        
		});    
						 	



		/*
	*	Fonction pour ajouter un utilisateur
	*/
	
	$("#ajouter_application").on('click', function(){
      	
      	// Dans le contenu de l'attribut ¬´ data-prototype ¬ª, on remplace :
	  	// - le texte "__name__label__" qu'il contient par le label du champ
	  	// - le texte "__name__" qu'il contient par le num√©ro du champ
	  	
	  	var tableL = $("#body_application");
                
        //On fait -1 car il y a la ligne du bouton "ajouter"
	  	var index = (tableL.find('tr').length)-1;
	  	
	  	
	 	       
    //On doit récupérer les options du select du service
	// Pour cela, on récupère les options du premier utilisateur(en partant du principe qu'il y a au moins 1 utilisateur ....)
	var strOptions = "";
 	//On récupère la ligne du premier utilisateur
 	var tr = tableL.find("tr:last");

  	//On va chercher son select, et on parcours les options
  	tr.find("select:first option").each(function() {
									
		//On créé un string que l'on ajoutera au moment voulu
		strOptions += "<option value='"+$(this).val()+"'>";
		strOptions += $(this).text();
		strOptions += "</option>";

	});  	
           
    
   
    var newLigne = "<tr>"
						  	
						+"<td>" 
							+"<input type='text' id='jc_commandebundle_listeapplications_listeApplications___name___nom' 																							name='jc_commandebundle_listeapplications[listeApplications][__name__][nom]' class='col-md-8 col-md-offset-2'>" 
						+"</td>"
						
						+"<td>"
							+"<select id='jc_commandebundle_listeapplications_listeApplications___name___fournisseur' 																								name='jc_commandebundle_listeapplications[listeApplications][__name__][fournisseur]' class='col-md-8 col-md-offset-2'>"
							+strOptions
						+"</select>" 
					+"</td>"						
				+"</tr>";
										
						 	
						 	
						 	
		// remplace les "__name__" utilis√©s dans l'id 
        // par un nombre unique 
        newLigne = newLigne.replace(/__name__/g, index);
								        
        // cr√©er une nouvelle liste d'√©l√©ments et l'ajoute √† notre liste
        $('#last_tr_application').after(newLigne);
								        
								     
        return false;				
						        
		});    
		
		
		
	
});    