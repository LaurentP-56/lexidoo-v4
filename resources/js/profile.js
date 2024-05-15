
/*active button class onclick*/
$('menu a').click(function(e) {
    e.preventDefault();
    $('menu a').removeClass('active');
    $(this).addClass('active');
    if(this.id === !'payment'){
        $('.payment').addClass('noshow');
    }
    else if(this.id === 'payment') {
        $('.payment').removeClass('noshow');
        $('.rightbox').children().not('.payment').addClass('noshow');
    }
    else if (this.id === 'profile') {
        $('.profile').removeClass('noshow');
        $('.rightbox').children().not('.profile').addClass('noshow');
    }
    else if(this.id === 'subscription') {
        $('.subscription').removeClass('noshow');
        $('.rightbox').children().not('.subscription').addClass('noshow');
    }
    else if(this.id === 'privacy') {
        $('.privacy').removeClass('noshow');
        $('.rightbox').children().not('.privacy').addClass('noshow');
    }
    else if(this.id === 'settings') {
        $('.settings').removeClass('noshow');
        $('.rightbox').children().not('.settings').addClass('noshow');
    }
});
