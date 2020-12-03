function $ (id){
	return document.getElementById(id);
};
window.onload = function (){
	var 	navagation ="<nav>";
		navagation+="	<a href=\"#main\" aria-label=\"Skip to main\"></a>";
		navagation+="	<a href=\"landing.html\"><img src=\"LogoWhensGoodLogo.svg\" class=\"img\" alt=\"comment pic\" /></a>";
		navagation+="	<ul class=\"list\">";
		navagation+="	<li>";
		navagation+="		<a class=\"button\" href=\"CreateEvent.html\">Create Event</a>";
		navagation+="		</li>";
		navagation+="		<li>";
		navagation+="			<a class=\"button\" href=\"Enter_EditEvent.html\">Edit Event</a>";
		navagation+="		</li>";
		navagation+="		<li>";
		navagation+="			<a class=\"button\" href=\"Enter_RSVP.html\">RSVP to an Event</a>";
		navagation+="		</li>";
		navagation+="		<li>";
		navagation+="			<a class=\"button\" href=\"Enter_ScheduleEvent.html\">Schedule Event</a>";
		navagation+="		</li>";
		navagation+="	</ul>";
		navagation+="</nav>";

	$("nav").innerHTML =	navagation;

	$("footer").innerHTML = "<p>You can also  use the donate button above to pay an invoice. Please include your invoice number in the comments section.<br>Thank you for being a partner of CFR.</p><p>Click <a href=\"ContactUs.html\"> HERE </a> for contact information";
};