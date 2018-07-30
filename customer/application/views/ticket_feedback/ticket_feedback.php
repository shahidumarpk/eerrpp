<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<form method="post" action="<?php echo SURL?>ticket_feedback/ticket-feedback/feedback_process">
<table width="458" height="496" border="0" align="center" style="border:1px solid #999;">
<?php if($this->session->flashdata('msg')){  ?>
  <tr>
    <td height="67" colspan="2" align="center"><?php echo $this->session->flashdata('msg'); ?></td>
    </tr>
  
 <?php  }?>
 
 
  <tr>
    <td height="45" colspan="2">Ticket Subject :  <?php echo $ticket_data['subject']; ?></td>
    </tr>
    <tr>
    <td height="43" colspan="2">Ticket Details :  <?php echo $ticket_data['details']; ?></td>
    </tr>
  
    <tr>
      <td height="21">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <td width="245" height="67">Is your issue resolved?</td>
    <td width="197">
      YES
      <input type="radio" name="issue_resolved" id="issue_resolved" value="yes" />
       NO
       <input type="radio" name="issue_resolved" id="issue_resolved" value="no" /></td>
  </tr>
  <tr>
    <td height="66">Have the customer support representative served you well?</td>
    <td>YES
      <input type="radio" name="customer_support" id="customer_support" value="yes" /> 
      NO
      <input type="radio" name="customer_support" id="customer_support" value="no" /></td>
  </tr>
  <tr>
    <td height="52">Are you satisfied with our services?</td>
    <td>YES
      <input type="radio" name="customer_satisfaction" id="customer_satisfaction" value="yes" />
NO
<input type="radio" name="customer_satisfaction" id="customer_satisfaction" value="no" /></td>
  </tr>
  <tr>
    <td>Customer Feedback :</td>
    <td><textarea name="customer_feedback" id="customer_feedback" cols="30" rows="3"></textarea></td>
  </tr>
  <tr>
    <td height="60"><input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>"  /></td>
    <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
  </tr>
</table>

</form>

</body>
</html>