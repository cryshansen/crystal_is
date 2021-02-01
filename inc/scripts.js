// JavaScript Document

//this function works for textarea in the Submitbio.php
function limitText(limitField, limitCount, limitNum) 
{
	if (limitField.value.length > limitNum) 
	{ 
		limitField.value = limitField.value.substring(0, limitNum);
	} 
	else 
	{
		limitCount.value = limitNum - limitField.value.length;
	}
}

//this function works for textarea in the Submitbio.php
function validate()
{
	if (!document.form.first_name.value)
	{
		alert( "Please enter the person's first name." );
		document.form.first_name.focus();
		return false ;
	}
	else if (!document.form.last_name.value)
	{
		alert( "Please enter the person's last name." );
		document.form.last_name.focus();
		return false ;
	}
	else if (!document.form.author_phone.value)
	{
		alert( "Please enter your phone number, 10 digits excluding brackets and dashes." );
		document.form.author_phone.focus();
		return false ;
	}
	else if(!document.form.author_email.value) 
	{
		alert( "Please enter your email address." );
		document.form.author_email.focus();
		return false ;
	}
	else if (!document.form.limitedtextarea.value)
	{
		alert( "Please supply a comment or question." );
		document.form.limitedtextarea.focus();
		return false ;
	}
	else
	{
		if(document.form.author_email.value)
		{
			var email_value = document.form.author_email.value;
			var atloc=email_value.indexOf("@",1);
			var dotloc=email_value.indexOf(".",atloc+2);
			var len=email_value.length;
			if(!(atloc>0 && dotloc>0 && len > dotloc+2))
			{
				alert("Please enter your proper email address format.");
				document.form.author_email.focus();
				return false;
			}
		}
		if(document.form.author_phone.value)
		{
			var phone = document.form.author_phone.value;
			//alert("your number is " + phone );
			if(isNaN(phone))
			{
				alert("Please enter a valid number, 10 digits excluding brackets and dashes.");
				document.form.author_phone.focus(); 
				return false;
			}
			else 
			{
				if (phone.length < 10)
				{
					alert("Please enter a ten digit phone number. Omit all spaces, brackets and dashes.");
					document.form.author_phone.focus(); 
					return false;
				}
			}
  		}
		return true ;
  	}
}
 
function escramble(){
 var a,b,c,d,e,f,g,h,i
 a='<a href=\"mai'
 b='Contact'
 c='\">'
 a+='lto:'
 b+='@'
 e='</a>'
  f='Click here to e-mail us your resume.'
 b+='shaw.ca'
 g='<img src=\"'
 h=''
 i='\" alt="Email us." border="0">'

 if (f) d=f
 else if (h) d=g+h+i
 else d=b

 document.write(a+b+c+d+e)
}

//<a href="mailto:Resume@IntellexSystems.com">   Click here to e-mail us your resume.</a>