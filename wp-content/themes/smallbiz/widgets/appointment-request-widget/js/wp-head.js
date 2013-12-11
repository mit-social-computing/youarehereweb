(function($){

	var format = function(num){
		if(parseInt(num, 10) < 10) {
			num = '0' + num;
		}
		return num;
	};

	var Kalendarz = function() {
	  // Wylicz datę wielkanocy: easter($year) -> {day:$day,month:$month}
	  var easter=function(y){var c,n,k,i,j,l,m,d,f=function(a){return Math.floor(a)};c=f(y/100);n=y-19*f(y/19);k=f((c-17)/25);i=c-f(c/4)-f((c-k)/3)+19*n+15;i=i-30*f((i/30));i=i-f(i/28)*(1-f(i/28)*f(29/(i+1))*f((21-n)/11));j=y+f(y/4)+i+2-c+f(c/4);j=j-7*f(j/7);l=i-j;m=3+f((l+40)/44);d=l+28-31*f(m/4);return{d:d,m:m}};
	 
	  // Sprawdź czy rok jest przestępny: leap(2012) -> true
	  var leap=function(y){return((y%4==0)&&(y%100!=0))||y%400==0};
	 
	  // Wylicz ilość dni dla podanego miesiąca i roku: days(12,2012) -> 29
	  var days=function(m,y){var d;if(m==2)d=leap(y)?29:28;else if(m<8)d=30+m%2;else if(m<13)d=30+(m%2==1?0:1);else throw('Bad month');return d};
	 
	  // Wylicz dzień tygodnia[0(niedziela)-6(sobota)]: day(6,1,2011) -> 4(czwartek)
	  var day=function(d,m,y){var D=new Date();D.setFullYear(y);D.setDate(d);D.setMonth(--m);return D.getDay()};
	 
	  // Polskie dni tygodnia [0(niedziela)-6(sobota)]
	  var dniTygodnia = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
	 
	  // Polskie miesiące [0(styczeń)-12(grudzień)]
	  var miesiace = ['January','February','March','April','May','June','July','August','September','October','Novembe','December'];
	 
	  // Święta Statyczne (http://pl.wikipedia.org/wiki/Dni_wolne_od_pracy)
	  var swietaStatyczne = function(){return[]};
	 
	  // Święta Ruchome (http://pl.wikipedia.org/wiki/Dni_wolne_od_pracy)
	  var swietaDynamiczne = function(y) {
	    var r = []; // tablica ze swietami
	    return r;
	  };
	 
	  // zwraca opis święta w danym dniu lub false
	  var czySwieto = function(d,m,y){
	    var p = swietaDynamiczne(y);
	    for(r in p) {r=p[r];if(r.d==d&&r.m==m)return r.o}
	    var p = swietaStatyczne(y);
	    for(r in p) {r=p[r];if(r.d==d&&r.m==m)return r.o}
	    if(day(d,m,y)==0) return 'Sunday';
	    return false;
	  };
	 
	  // pobierz informacje o miesiącu, bez parametrów pobiera aktualną datę
	  this.info = function(m,y){
	    // default
	    var time = new Date();
	    if(!m)m=time.getMonth()+1;
	    if(!y)y=time.getFullYear();
	    // sprawdź poprawność
	    if(m<1 || m>12) throw('Bad month');
	    var d = day(1,m,y),id=days(m,y),s=[];
	    for(var i=1; i<=id; i++) {
	      var sw = czySwieto(i,m,y);
	      if(sw !== false && sw != 'Niedziela') s.push({dzien:i,nazwa:sw});
	    }
	    return{
	      rok:y,
	      miesiac: {nr:m,nazwa:miesiace[m-1]},
	      startTygodnia: {nr:d,nazwa:dniTygodnia[d]},
	      iloscDni: id,
	      swieta: s
	    };
	  };
	 
	  this.dzienPL=function(nr){return dniTygodnia[nr]};
	};
	
	var GenerujKalendarz = function(e,m,y) {
	  var k = new Kalendarz();
	  var info = k.info(m,y),code;
	  m=info.miesiac.nr; // if undefined
	  // pobierz ilość dni w poprzednim miesiącu
	  var last = {y:info.rok,m:info.miesiac.nr}
	  if(last.m==1){last.y--;last.m=12}else last.m--;
	  lastDay = k.info(last.m,last.y).iloscDni;
	  // generuj kod html
	  code = '<table class="kalendarz"><tbody><tr><th colspan="7"><span class="miesiac"><span class="btn predMonth">&lt;&lt;</span> <span class="btn nextMonth">&gt;&gt;</span> ' + info.miesiac.nazwa.toLowerCase() + '</span><span class="rok">' + info.rok + ' <span class="btn predYear">&lt;&lt;</span> <span class="btn nextYear">&gt;&gt;</span></span></th></tr><tr>';
	  for(var i=1;i<7;i++) code += '<th class="dzien-tygodnia">' + k.dzienPL(i).substr(0,3).toLowerCase() + '</th>';
	  code += '<th class="dzien-tygodnia niedziela">' + k.dzienPL(0).substr(0,3).toLowerCase() + '</th></tr><tr>';
	  for(var i=1;i<=42;i++){
	    var dzien = i-(info.startTygodnia.nr==0 ? 7 : info.startTygodnia.nr)+1;
	    var title = format(dzien) + '/' + format(m) + '/' + info.rok;
	    // pobierz święta
	    var swieto = false;
	    // buduj dalej
	    code += '<td title="' + (dzien<1 || dzien>info.iloscDni ? '' : title) + '" class="dzien'
	      + (dzien<1 || dzien>info.iloscDni ? ' nieaktywny' : ' aktywny')
	      + (swieto ? ' swieto' : '')
	      + (i%7==0 ? ' niedziela': '') + '">'
	      + (dzien>0 ? (dzien<=info.iloscDni ? dzien : dzien-info.iloscDni ) : lastDay + dzien)
	    + '</td>';
	    if(i%7==0 && i<42) code += '</tr><tr>';
	  }
	  code += '</tr></tbody></table>';
	  e.innerHTML = code; // dopisz do elementu
	  e.onselectstart = function(){return false}; // zablokuj możliwość zaznaczania tekstu
	  // oskryptowanie przycisków
	  jQuery(e).find('.predMonth').click(function(){
	    GenerujKalendarz(e,last.m,last.y);
	  });
	  jQuery(e).find('.nextMonth').click(function(){
	    var last = {y:info.rok,m:info.miesiac.nr}
	    if(last.m==12){last.y++;last.m=1}else last.m++;
	    GenerujKalendarz(e,last.m,last.y);
	  });
	  jQuery(e).find('.predYear').click(function(){
	    GenerujKalendarz(e,info.miesiac.nr,--info.rok);
	  });
	  jQuery(e).find('.nextYear').click(function(){
	    GenerujKalendarz(e,info.miesiac.nr,++info.rok);
	  });
	};

	$(function(){
		$('.appointment-request-widget .calendar').each(function(k,v){
			GenerujKalendarz(v);
		});
		
		$('.appointment-request-widget .calendar .dzien.aktywny').live('click', function(){
			var $this = $(this);
			var parent = $this.parent().parent().parent().parent().parent();
			parent.find('.datepicker input').val($this.attr('title'));
			parent.find('.calendar').slideUp(200);
		});
		
		$('.appointment-request-widget button.submit').click(function(){
			var $this = $(this);
			var date = $this.parent().parent().find('.datepicker input').val();
			var time = $this.parent().parent().find('select').val();
			if(!date.match(/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/)) {
				alert('Please pick up date first');
			} else {
				var box = $('#appointment_request_widget_footer_iframe');
				box.find('iframe').attr('src', appointment_request_widget_submit_path + '&date=' + date + '&time=' + time);
				$('#wpadminbar').hide();
				box.fadeIn(200);
			}
		});
		$('.appointment-request-widget .datepicker input, .appointment-request-widget .datepicker img').click(function(){
			var parent = $(this).parent().parent().parent().find('.calendar');
			if(parent.css('display') == 'none') {
				parent.slideDown(200);
			} else {
				parent.slideUp(200);
			}
		});
		
		$('#appointment_request_widget_footer_iframe button').click(function(){
			$(this).parent().fadeOut(200, function(){
			  $('#wpadminbar').show();
			});
		});
	});
})(jQuery);
