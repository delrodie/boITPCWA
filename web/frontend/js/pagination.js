/*
 ******* www.devandclick.fr *******

 modeles :
 1 : suivant,precedent
 2 : pagination
 3 : pagination + suivant,precedent
 
 @nbParPage : nombre d'elements par page
 @divSelect : elements a paginer
 @divPager : nom du div ou s'insere la pagination
 @model : Modeles de pagination voir ci-dessus
 */
function pagination(nbParPage,divSelect,divPager,model)
{	
    //Initialisation
    var nbElem = $(divSelect).length;
    var nbPage = Math.ceil(nbElem / nbParPage);
    var pageLoad = 1;
    
    $(divSelect).each(function(index) {
        if (index < nbParPage)
            $(divSelect).eq(index).show();
        else
            $(divSelect).eq(index).hide();
    });
    
    //Reset & verification
    function reset() {
        if (nbPage < 2) $(divPager).hide();
        if (pageLoad == nbPage) $(divPager + ' li> a> i.fa.fa-angle-double-right').hide(); else $(divPager + ' li a').show();
        if (pageLoad == 1) $(divPager + ' li> a> i.fa.fa-angle-double-left').hide(); else $(divPager + ' li a').show();
        $(divPager + ' ul.pg-pagination li a').removeClass('selected');
        $(divPager + ' ul.pg-pagination li a').eq(pageLoad -1).addClass('selected');
    }
    
    //Pagination generation
    if (model != 1) {
        $(divPager).html('<ul class="pg-pagination"></ul>').addClass('pg-pagination');
        for(i = 1; i <= nbPage; i++) $(divPager + ' ul.pg-pagination').append('<li><a href="#">' + i + '</a></li>');
    
        //Changement click page
        $(divPager + ' ul.pg-pagination li').click(function() {
            if ($(this).index() + 1 != pageLoad) {
                pageLoad = $(this).index() + 1;
                $(divSelect).hide();
                
                $(divSelect).each(function(i) {
                    if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
                });
                
                reset();
            }
        });
    }
    
    //Suivant Precedent
    if (model == 1) {
        $(divPager).prepend('<li><a><i class="fa fa-angle-double-left"></i>');
        $(divPager).append('<li><a><i class="fa fa-angle-double-right"></i>');
    } else if (model == 3) {
        $(divPager + ' ul.pg-pagination').before('');
        $(divPager + ' ul.pg-pagination').after('');
    }
	
	//Evenement click sur suivant
    $(divPager + ' <li><a><i class="fa fa-angle-double-right">').click(function() {
        if (pageLoad < nbPage) {
            pageLoad += 1;
            $(divSelect).hide();
            
            $(divSelect).each(function(i) {
                if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
            });
            
            reset();
        }
    });
	
	//Evenement click sur precedent
    $(divPager + ' <li><a><i class="fa fa-angle-double-left">').click(function() {
        if (pageLoad -1 >= 1) {
            pageLoad -= 1;
            $(divSelect).hide();
            
            $(divSelect).each(function(i) {
                if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
            });
            
            reset();
        }
    });
    
    reset();
}