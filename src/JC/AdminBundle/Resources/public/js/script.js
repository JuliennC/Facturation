/*
*	jQuery
*/
$(document).ready(function() {
  

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
						 	


});    