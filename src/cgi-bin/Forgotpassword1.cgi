#!/usr/bin/perl -w
use warnings;
use strict; 
use CGI; 
use Fcntl qw(:flock);

use CGI::Carp qw(fatalsToBrowser);

my $cgi = new CGI;

# Read in the email-id from user
my $email = $cgi->param( "email" );

my $send = "fail";
my $username = "u";
my $password = "p";

open(FPASSWORDDATA, "<Forgotpassword.txt") or die "Can not open password.txt";

#Read in the data from the password.txt file
break: while(<FPASSWORDDATA>)
{
	my $line = $_;
	my @enamepass = split(' ',$line);
	if($enamepass[0] eq $email)
	{
		$username=$enamepass[1];
		$password=$enamepass[2];
	  	$send = "success";
	  	last break;
	}
		  
}
close(FPASSWORDDATA);
#displayOtherHTMLPage($cgi);

if($send eq "success")
{		
	
	print $cgi->header( "text/html" );
	
	print("<meta http-equiv='refresh' content='2;url=http://cs99.bradley.edu/~bgalla/Assignment1/LoginForm.html' />");
	
	print $cgi->start_html( 
        	-title    => "Welcome To Music Club",			
		
		-text=>"black"
		
        ),
	$cgi->h2(" Your login details are sent to your mail"),
	
	$cgi->end_html;

	

}
else
{
	print $cgi->header( "text/html" );
	
	print("<meta http-equiv='refresh' content='2;url=http://cs99.bradley.edu/~bgalla/Assignment1/LoginForm.html' />");
	
	print $cgi->start_html( 
        	-title    => "Welcome To Music Club",			
		
		-text=>"black"
		
        ),
	$cgi->h2(" Sorry! This email-Id is not registered"),
	
	$cgi->end_html;
	
	exit;

}



#Sending password and username to user mail

print $cgi->header( "text/html" );

print $cgi->start_html( "Mail sent"),


my $to = $email;

my $from = 'noreply@musicclub.com';

my $subject = 'Music club Login details';

my $messagef = 'Your Login Details for Music Club 

You can login to our website with your Username:';

my $messagem = ' & Password:';

my $messages='


Thanks & Regards
Music club';

$cgi->end_html;

open(MAIL, "|/usr/sbin/sendmail -t");


# Email Header
print MAIL "To: $to\n";

print MAIL "From: $from\n";

print MAIL "Subject: $subject\n\n";

# Email Body
print MAIL $messagef;print MAIL $username;print MAIL $messagem;print MAIL $password;
print MAIL $messages;

close(MAIL);	
