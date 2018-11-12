var i=0;
var x=0;
 function aktiviraj(s) {
	for(x=1;x>5;x++){
		if(s==x){
				document.getElementById('n'+x).style.backgroundColor = "Blue";
				document.getElementById('slks').src='img/'+x+'.jpg';
			}
			else deaktiviraj(x);
			}
	}

function deaktiviraj(s) {
	 document.getElementById('n'+s).style.backgroundColor = "red";
	
}
 

function slider( )
{
    setInterval(function(){ i=i+1; if(i>4) i=1;  aktiviraj(i);  }, 2000);
}


