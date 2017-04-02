#!/usr/bin/perl -w
use strict;
use warnings;
use CGI;
use Fcntl qw(:flock);

my $cgi = new CGI;
my $username = $cgi->param( "username" );
my $password = $cgi->param( "password" );

my $email = $cgi->param( "email" );

my $gender=$cgi->param("r1");
my $month= $cgi->param( "month" );
my $date = $cgi->param( "date" );
my $year = $cgi->param( "year" );
my $phonef= $cgi->param( "phone-1" );
my $phones = $cgi->param( "phone-2" );
my $phonet = $cgi->param( "phone-3" );
my $address= $cgi->param( "address" );
my $file = $cgi->param( "file" );
my $q = new CGI;
my $salt = "21";
my $enpass = crypt($password,$salt);
my $filename = 'password.txt';
my $registerfile='registerinfo.txt';


open(my $li, '>>', $filename) or die "Could not open file password.txt !";


print $li "$username $enpass\n";



close $li;

open(my $ri, '>>', $registerfile) or die "Could not open file registerinfo.txt !";


print $ri "Username:$username\n";
print $ri "Password$password\n";
print $ri "Email-id:$email\n";
print $ri "Gender:$gender\n";
print $ri "Date of Birth:$month,$date $year\n";
print $ri "Phone no: ($phonef)-$phones-$phonet\n";
print $ri "Address:$address\n\n";

close $ri;



print $cgi->header( "text/html" );


print("<meta http-equiv='refresh' content='5;url=http://cs99.bradley.edu/~bgalla/Regsuccess.html' />");


print $cgi->start_html( "Registration Success" ),


$cgi->h2("User Details"), 
$cgi->h3("Name: $username"),
$cgi->h3("password: $password"),
$cgi->h3("Email_Id: $email"),
$cgi->h3("Date of Birth:$month, $date  $year"),
$cgi->h3("Gender: $gender"),
$cgi->h3("Phone.no: ($phonef) $phones - $phonet"),
$cgi->h3("Address: $address"),



$cgi->h3("photo:$file"),
$cgi->h2(" Registration Successful, you will be redirected to registration successful page in 10 seconds..."),


 

my $to = $email;

my $from = 'noreply@musicclub.com';

my $subject = 'Registration Confirmation';

my $message = 'Hey congrats!! You are now a member of MUSIC CLUB. 

Your registration is successful.
Enjoy our services:)....!!!


Thanks & Regards
Music club';


$cgi->end_html;


open(MAIL, "|/usr/sbin/sendmail -t");


# Email Header
print MAIL "To: $to\n";

print MAIL "From: $from\n";

print MAIL "Subject: $subject\n\n";

# Email Body
print MAIL $message;

close(MAIL);	
	


