<?
$body="
Hi. This is the qmail-send program at difusion.cce.org.uy.
I'm afraid I wasn't able to deliver your message to the following addresses.
This is a permanent error; I've given up. Sorry it didn't work out.

<enarmonico@montevideo.com>:
Sorry, I wasn't able to establish an SMTP connection. (#4.4.1)
I'm not going to try again; this message has been in the queue too long.

--- Below this line is a copy of the message.

Return-Path: <difusion@difusion.cce.org.uy>
Received: (qmail 14022 invoked by uid 48); 26 May 2009 19:24:24 -0300
To: enarmonico@montevideo.com
Subject: =?utf-8?Q?CCE:_S=C3=A1bado_30,_12:30_hs._Ciclo_El_piano_solista_(III)._M?=  =?utf-8?Q?=C3=BAsica_uruguaya_para_piano_con_Mayra_Hern=C3=A1ndez?=
Date: Tue, 26 May 2009 19:24:24 -0300
From: =?utf-8?Q?Centro_Cultural_de_Espa=C3=B1a?= <difusion@difusion.cce.org.uy>
Reply-To: =?utf-8?Q?Centro_Cultural_de_Espa=C3=B1a?= <difusion@cce.org.uy>
Message-ID: <f08a880012b0f5834dda57b17a3c8e68@difusion.cce.org.uy>
X-Priority: 3
X-Mailer: PHPMailer (phpmailer.sourceforge.net) [version 2.0.0 rc3]
X-guid: MU3XHGY6SL15DFA6108130
MIME-Version: 1.0
Content-Type: multipart/alternative;

";

echo "<br>";
preg_match ("/<(\S+@\S+\w)>.*\n?.*I wasn\'t able to establish an SMTP connection. \(\#4\.4\.1\).*\n?.*I\'m not going to try again/",$body,$match);
print_r($match);

echo "<br>";
preg_match("/x\-guid: ((.)*)\n?/i",$body,$match);
print_r($match);

?>