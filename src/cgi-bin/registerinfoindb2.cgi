#!/usr/bin/perl -w
use strict;
use warnings;
use CGI;
use Fcntl qw(:flock);
use CGI::Carp qw ( fatalsToBrowser );
use File::Basename;


my $cgi = new CGI;
$CGI::POST_MAX = 1024 * 5000;
my $safe_filename_characters = "a-zA-Z0-9_.-";
my $upload_dir = "/home/bgalla/public_html/Assignment1/cgi-bin/upload1";

#Reading data from user 
my $username = $cgi->param( "username" );
my $password = $cgi->param( "password" );

my $email = $cgi->param( "email" );

my $gender=$cgi->param("r1");
my $month= $cgi->param( "month" );
my $date = $cgi->param( "date" );
my $year = $cgi->param( "year" );
my $phonef= $cgi->param( "phonef" );
my $phones = $cgi->param( "phones" );
my $phonet = $cgi->param( "phonet" );
my $address= $cgi->param( "address" );
my $file = $cgi->param("photo");
my $nam="photo";
if ( !$file )
{
print $cgi->header ( );
print "There was a problem uploading your photo (try a smaller file).";
exit;
}

my ( $name, $path, $extension ) = fileparse ( $nam, '..*' );
$file = $nam . $extension;
$file =~ tr/ /_/;
$file =~ s/[^$safe_filename_characters]//g;

if ( $file =~ /^([$safe_filename_characters]+)$/ )
{
$file = $1;
}
else
{
die "Filename contains invalid characters";
}

my $upload_filehandle = $cgi->upload("photo");

open ( UPLOADFILE, "+>$upload_dir/$file" ) or die "$!";
binmode UPLOADFILE;

while ( <$upload_filehandle> )
{
print UPLOADFILE;
}

close UPLOADFILE;



my $salt = "21";
my $enpass = crypt($password,$salt);

my $filename = 'password.txt';
my $filenamefp = 'Forgotpassword.txt';
my $filenamesur = 'singleuserreginfo.txt';
my $registerfile='registerinfo.txt';


#opening password.txt

open(my $li, '>>', $filename) or die "Could not open file password.txt !";


print $li "$username $enpass\n";


close $li;


#opening Forgotpassword.txt

open(my $fi, '>>', $filenamefp) or die "Could not open file Forgotpassword.txt !";

print $fi "$email $username $password\n";

close $fi;


#opening singleuserreginfo.txt

open(my $si, '+>', $filenamesur) or die "Could not open file singleuserreginfo.txt !";

print $si "Username:$username\n";
print $si "Password:$password\n";
print $si "Email-id:$email\n";
print $si "Gender:$gender\n";
print $si "Date of Birth:$month,$date $year\n";
print $si "Phone no: ($phonef)-$phones-$phonet\n";
print $si "Address:$address\n\n";

close $si;


#Opening registerinfo.txt

open(my $ri, '>>', $registerfile) or die "Could not open file registerinfo.txt !";


print $ri "Username:$username\n";
print $ri "Password:$password\n";
print $ri "Email-id:$email\n";
print $ri "Gender:$gender\n";
print $ri "Date of Birth:$month,$date $year\n";
print $ri "Phone no: ($phonef)-$phones-$phonet\n";
print $ri "Address:$address\n\n";

close $ri;

print $cgi->header ("text/html");
print <<END_HTML;
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thanks!</title>
<style type="text/css">
img {border: none;}
</style>
</head>
<body>
<p>Thanks for uploading your photo!</p>
<p>Your email address: $email</p>
<p>Your photo:</p>
<p><img src="http://cs99.bradley.edu/~bgalla/Assignment1/cgi-bin/upload1/$file" alt="photo" /></p>
</body>
</html>
END_HTML


print $cgi->header( "text/html" );


print("<meta http-equiv='refresh' content='5;url=http://cs99.bradley.edu/~bgalla/Assignment1/RegistrationSuccess.html' />");


print $cgi->start_html( "Registration Success" ),
$cgi->start_html(
        	-title    => "Welcome To Music Club",			
		-topmargin =>"0",
		-text=>"black"
		
        ),


$cgi->h2(" Registration Successful"),
$cgi->h3(" Your Details"),

#Prints the user details in a table.
$cgi->start_table ({-border=>'1', -align=>'center'}), "\n",

        $cgi->start_Tr,
                $cgi->start_td,
                "Username",
                $cgi->end_td,
                $cgi->start_td,
                "Password",
                $cgi->end_td,
		 $cgi->start_td,
                "Email-id",
                $cgi->end_td,
                $cgi->start_td,
                "Gender",
                $cgi->end_td,
 		$cgi->start_td,
                "Date of Birth",
                $cgi->end_td,
                $cgi->start_td,
                "Phone no",
                $cgi->end_td,
 		 $cgi->start_td,
                "Address",
                $cgi->end_td,
        $cgi->end_Tr,
        $cgi->start_Tr,
                $cgi->start_td,
                "$username",
                $cgi->end_td,
                $cgi->start_td,
                "$password",
                $cgi->end_td,
		 $cgi->start_td,
                "$email",
                $cgi->end_td,
                $cgi->start_td,
                "$gender",
                $cgi->end_td,
 		$cgi->start_td,
                "$month,$date $year",
                $cgi->end_td,
                $cgi->start_td,
                "($phonef)$phones-$phonet",
                $cgi->end_td,
 		 $cgi->start_td,
                "$address",
                $cgi->end_td,
        $cgi->end_Tr,
        $cgi->end_table, "\n",

$cgi->h2("You will be redirected to registration successful page in 10 seconds"),


#Sending registration conformation mail
my $to = $email;

my $from = 'noreply@musicclub.com';

my $subject = 'Registration Confirmation';

my $messagef = 'Hey congrats! You are now a member of MUSIC CLUB. 

Your registration is successful.
You can login to our website with your username:';


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
print MAIL $messagef;print MAIL $username;
print MAIL $messages;

close(MAIL);	
	


