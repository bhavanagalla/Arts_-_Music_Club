#!/usr/bin/perl -w
use strict; 
use warnings;
use CGI; 
use Fcntl qw(:flock);

my $cgi = new CGI;

# Read in the data from HTML form
my $username = $cgi->param( "username" );
my $password = $cgi->param( "password" ); 

my $email;

my $login = "fail";
my $elogin = "fail";
my $salt = "21";
my $enpass = crypt($password,$salt);
open(PASSWORDDATA, "<password.txt") or die "Can not open password.txt";

#Read in the data from the password.txt file
break: while(<PASSWORDDATA>)
{
	my $line = $_;
	my @namepass = split(' ',$line);
	if($namepass[0] eq $username && $namepass[1] eq $enpass)
	{
	  $login = "success";
	  last break;
	}
		  
}
close(PASSWORDDATA);
#displayOtherHTMLPage($cgi);

if($login eq "success")
{		
	displayOtherHTMLPage($cgi);
	print $cgi->header( "text/html" );
	print("<meta http-equiv='refresh' content='5;url=http://cs99.bradley.edu/~bgalla/Assignment1/loginsuccess.html' />");
}
else
{
	print $cgi->header( "text/html" ),
	$cgi->start_html(
		-title    => "Welcome To Music Club",
       		-text=>"black"
		),
	$cgi->h2("Sorry! Login Failed...Incorrect Username or Password..."),
	$cgi->h2("Relogin"),
	$cgi->end_html;
	exit;
}

my $filenameslsi = 'loginsuccess.txt';

#opening loginsuccess.txt

open(my $lsi, '+>', $filenameslsi) or die "Could not open file loginsuccess.txt !";

print $lsi "Welcome!\n";
print $lsi "Your username:$username\n";
print $lsi "Your password:$enpass\n";

close $lsi;



open(FORGOTDATA, "<usermail.txt") or die "Can not open usermail.txt";

    
#Read in the data from the usermail.txt file
break: while(<FORGOTDATA>)
{
	my $line = $_;
	my @emailname = split(' ',$line);
	if($emailname[0] eq $username)
	{
	  $email=$emailname[1];
	  $elogin="success";
	     
	last break;
	}
		  
}
close(FORGOTDATA);
#opening singlelogin.txt
my $singlelogin = 'singlelogin.txt';
open(my $sl, '+>', $singlelogin) or die "Could not open file singlelogin.txt !";

		print $sl "$username $email\n";
		close $sl;

if($elogin eq "success")
{		
	print $cgi->header( "text/html" ),
	$cgi->start_html(
		-title    => "Welcome To Music Club",
       		-text=>"black"
		),
	$cgi->h2("email id success $email"),
	$cgi->end_html;
	exit;
 
}
else
{
print $cgi->header( "text/html" ),
	$cgi->start_html(
		-title    => "Welcome To Music Club",
       		-text=>"black"
		),
	$cgi->h2("email id fail"),
	$cgi->end_html;
	exit;

}

# creates the Other page
sub displayOtherHTMLPage {
	my( $cgi ) = @_;
	my @username = split('@',$cgi->param( "username" ));
	my $user = $username[0];
	
	print $cgi->header( "text/html" ),
	$cgi->start_html(
        	-title    => "Welcome To Music Club",			
		-topmargin =>"0",
		-text=>"black"
		
        ),
	
	$cgi->h1("Welcome to Music Club!  $user $enpass"),
	$cgi->end_html;    
}
