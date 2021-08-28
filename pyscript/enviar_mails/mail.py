#!/usr/bin/python

import smtplib

sender = 'franber.cba@gmail.com'
receivers = ['franber.cba@gmail.com']

message = """From: Fran <franber.cba@gmail.com>
To: To Person <franber.cba@gmail.com>
Subject: SMTP e-mail test

This is a test e-mail message.
"""

try:
   smtpObj = smtplib.SMTP('localhost')
   smtpObj.sendmail(sender, receivers, message)         
   print ("Successfully sent email")
except Exception as SMTPException:
   print ("Error: unable to send email")