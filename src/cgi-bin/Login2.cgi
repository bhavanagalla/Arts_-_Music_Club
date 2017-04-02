#!/usr/bin/perl -wT
use strict; 
use CGI; 
use Fcntl qw(:flock);

my $cgi = new CGI;

# Read in the data from HTML form
my $username = $cgi->param( "username" );
my $password = $cgi->param( "password" ); 
#$username = "cs531";
#$password = "web"; 

my $login = "fail";
my $salt = "21";
my $enpass = crypt($password,$salt);
open(PASSWORDDATA, "<password.txt") or die "Can not open password.txt";

my $findn=$username;
#Read in the data from the password.txt file
my @lines=<PASSWORDDATA>;
for(@lines)
{
	if($_ eq $findn)
	{
	  $login = "success";
	  last break;
	}
       
}
#break: while(<PASSWORDDATA>)

close(PASSWORDDATA);
#displayOtherHTMLPage($cgi);

if($login eq "success")
{		
	displayOtherHTMLPage($cgi);
	print("<meta http-equiv='refresh' content='5;url=http://cs99.bradley.edu/~bgalla/Assignment1/samplelogin.html' />");
}
else
{
	print $cgi->header( "text/html" );
	print("<meta http-equiv='refresh' content='2;url=http://cs99.bradley.edu/~bgalla/Assignment1/samplelogin.html' />");
	print $cgi->start_html( "Welcome to Half Time" ),
	$cgi->h2(" Sorry! Login Failed, Automatically you will be redirected to login page"),
	$cgi->end_html;
}


# creates the Other page
sub displayOtherHTMLPage {
	my( $cgi ) = @_;
	my @username = split('@',$cgi->param( "username" ));
	my $user = $username[0];
	
	print $cgi->header( "text/html" ),
	$cgi->start_html(
        	-title    => "Welcome To Music Club",			
		-topmargin =>"0"
        ),
	
	$cgi->h1("Welcome to Music Club!  $user $enpass"),
	$cgi->end_html;    
}
