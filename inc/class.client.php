<?php
class TbEnumerate_Client{
	var $i_number;
	var $base;
	var $i_maxnumber;
	
	public function __construct() {

	$this->i_maxnumber = 10000;
	$this->i_number = 10;
	$this->base = 2;

	}
	
	public function nextSymbol ($s_currentsymbol, $a_symbol, $i_maxindex, &$i_retained) 
	 {
	  $i_retained = 0;
	  $i_index = 0;
	  $b_find = FALSE;
	  while ( ($i_index <= $i_maxindex) && ($b_find == FALSE) )
	   {
	    if ( $s_currentsymbol == $a_symbol[$i_index] ) 
	     {
	      $b_find = TRUE;
	      if ( $i_index == $i_maxindex ) 
	       {
		$i_retained = 1;
		$s_result = "0";
	       }
	      else
	       {
		$i_retained = 0;
		$i_nextindex = $i_index + 1;
		$s_result = $a_symbol[$i_nextindex];
	       }
	     }
	    else
	     {
	      $i_index++;
	     }
	   }
	  return $s_result;  
	 }


	public function makeToEnumerate($content) 
	{ 
    $a_number = array();
	$a_nextrank = array();
	$a_symbol = array();

	if (isset($this->i_number) && isset($this->base) )
	 {
	  $i_maxenumerate = intval($this->i_number);
	  $i_base = intval($this->base);
	 }
	else
	 {
	  if (isset($_GET['nombre']) && isset($_GET['base']) )
	   {
	    $i_maxenumerate = intval($_GET['nombre']);
	    $i_base = intval($_GET['base']);
	   }
	  else
	   {
	    // $i_maxenumerate = 10;
	    // $i_base = 2;
	    return $content;
	   }
	 }

	$buffer=$content;

	$a_symbol[0] = "0"; $a_symbol["5"] = "5";
	$a_symbol[1] = "1"; $a_symbol["6"] = "6";
	$a_symbol[2] = "2"; $a_symbol["7"] = "7";
	$a_symbol[3] = "3"; $a_symbol["8"] = "8";
	$a_symbol[4] = "4"; $a_symbol["9"] = "9";

	$a_symbol[10] = "A"; $a_symbol[15] = "F";
	$a_symbol[11] = "B"; $a_symbol[16] = "G";
	$a_symbol[12] = "C"; $a_symbol[17] = "H";
	$a_symbol[13] = "D"; $a_symbol[18] = "I";
	$a_symbol[14] = "E"; $a_symbol[19] = "J";

	$a_symbol[20] = "K"; $a_symbol[25] = "P";
	$a_symbol[21] = "L"; $a_symbol[26] = "Q";
	$a_symbol[22] = "M"; $a_symbol[27] = "R";
	$a_symbol[23] = "N"; $a_symbol[28] = "S";
	$a_symbol[24] = "O"; $a_symbol[29] = "T";

	$a_symbol[30] = "U"; $a_symbol[35] = "Z";
	$a_symbol[31] = "V"; 
	$a_symbol[32] = "W"; 
	$a_symbol[33] = "X"; 
	$a_symbol[34] = "Y"; 

	/*
	  $i_toenumerate represente le nombre en base 10 a atteindre en base n
	  $i_nummaxrank represente le nombre de rang necessaire pour l'atteindre
	*/
	if ( $i_base > 36 ) 
	{ 
	 $i_base = 36;
	}
	if ( $i_base < 2 ) 
	{ 
	 $i_base = 2;
	}

	if ( $i_maxenumerate > $this->i_maxnumber ) 
	{ 
	 $i_maxenumerate = $this->i_maxnumber;
	}
	if ( $i_maxenumerate < 0 ) 
	{ 
	 $i_maxenumerate = 0;
	}

	$i_nummaxrank = round(log ($i_maxenumerate, $i_base)+1);

	/*
	  si il faut 8 rangs (de 0 à 7) pour representer $i_toenumerate
	  le nombre de depart sera egale à $s_parameter = "00000000"
	*/
	$s_parameter = str_pad ( "0" , $i_nummaxrank , "0" );


	$a_number = array_reverse(preg_split('//', $s_parameter, -1, PREG_SPLIT_NO_EMPTY));
	$i_nummaxrank = strlen ($s_parameter) - 1;

	$i_retained = 0;
	$i_indicemax = $i_base - 1;

	$symbolmax = $i_base - 1;

	switch ( $i_base )
	 {
	  case 20:
	  $buffer .= "<b>".__('The base', 'tb-enumerate')." ".$i_base." ".__('or', 'tb-enumerate')." <i>".__('vigesimal base', 'tb-enumerate')."</i></b>.<br />";
	  $buffer .= __('The base', 'tb-enumerate')." ".$i_base." ".__('Bhutan is Dzongkha language, and was in use among the Aztecs and for the Mayan count. Some think it was also used by the Gauls or the Basques in the early stages, but it is not actually count if their was a decimal character or vigesimal', 'tb-enumerate').".<br />";
	  $buffer .=  __('We have', 'tb-enumerate')." <b>".$i_base." ".__('available symbols', 'tb-enumerate')."</b> ".__('in vigesimal base', 'tb-enumerate')." <sub>($i_base)</sub> : [";
	  break;
	  case 16:
	  $buffer .= "<b>".__('The base', 'tb-enumerate')." ".$i_base." ".__('or', 'tb-enumerate')." <i>".__('hexadecimal base', 'tb-enumerate')."</i></b>.<br />";
	  $buffer .= __('The base', 'tb-enumerate')." ".$i_base." ".__('is mainly used in computers. She can count from 0 to 255 in 2 positions (00 to FF)', 'tb-enumerate').".<br />";
	  $buffer .= __('We group the consecutive numbers in binary quartets (from the right) with 8 bits (8 positions)', 'tb-enumerate').".<br />";
	  $buffer .= __('To the number', 'tb-enumerate')." 2F<sub>".$i_base."</sub> (47<sub>10</sub>) ".__('was binary number', 'tb-enumerate')." 0010 1111<sub>2</sub><br />";
	  $buffer .=  __('We have', 'tb-enumerate')." <b>".$i_base." ".__('available symbols', 'tb-enumerate')."</b> ".__('in hexadecimal base', 'tb-enumerate')." <sub>($i_base)</sub> : [";
	  break;
	  case 8:
	  $buffer .= "<b>".__('The base', 'tb-enumerate')." ".$i_base." ".__('or', 'tb-enumerate')." <i>".__('octal base', 'tb-enumerate')."</i></b>.<br />";
	  $buffer .= __('We group the consecutive numbers in binary triplets (from the right)', 'tb-enumerate').".<br />";
	  $buffer .= __('To the number', 'tb-enumerate')." 112<sub>".$i_base."</sub> (74<sub>10</sub>) ".__('was binary number', 'tb-enumerate')." 001 001 010<sub>2</sub><br />";
	  $buffer .=  __('We have', 'tb-enumerate')." <b>".$i_base." ".__('available symbols', 'tb-enumerate')."</b> ".__('in octal base', 'tb-enumerate')." <sub>($i_base)</sub> : [";
	  break;
	  case 5:
	  $buffer .= "<b>".__('The base', 'tb-enumerate')." ".$i_base." ".__('or', 'tb-enumerate')." <i>".__('quinary base', 'tb-enumerate')."</i></b>.<br />";
	  $buffer .= __('The base', 'tb-enumerate')." ".$i_base." ".__('was used among the earliest civilizations and into the twentieth century by African peoples, but also partly in the Roman and Mayan ratings', 'tb-enumerate').".<br />";
	  $buffer .= __('We have', 'tb-enumerate')." <b>$i_base ".__('available symbols', 'tb-enumerate')."</b> ".__('in quinary base', 'tb-enumerate')." <sub>($i_base)</sub> : [";
	  break;
	  case 2:
	  $buffer .= "<b>".__('The base', 'tb-enumerate')." ".$i_base." ".__('or', 'tb-enumerate')." <i>".__('binary base', 'tb-enumerate')."</i></b>.<br />";
	  $buffer .= __('The base', 'tb-enumerate')." ".$i_base." ".__('is used by our computers', 'tb-enumerate').".<br />";
	  $buffer .= __('We group the consecutive numbers in binary quartets (from the right)', 'tb-enumerate').".<br />";
	  $buffer .= __('To the number', 'tb-enumerate')." 3F<sub>16</sub> (63<sub>10</sub>) ".__('was binary number', 'tb-enumerate')." 0011 1111<sub>2</sub><br />";
	  $buffer .=  __('We have', 'tb-enumerate')." <b>".$i_base." ".__('available symbols', 'tb-enumerate')."</b> ".__('in binary base', 'tb-enumerate')." <sub>($i_base)</sub> : [";
	  break;
	  default :
	  $buffer .= __('We have', 'tb-enumerate')." ".$i_base." ".__('available symbols in base', 'tb-enumerate')." "."<sub>".$i_base."</sub> : [";
	 }

	for ($i = 0; $i <= $symbolmax; $i++) {
	    $buffer .= "<b><i> ".$a_symbol[$i]."  </i></b>";
	    if ($i < $symbolmax)
	     {
	      $buffer .= ", ";
	     }
	}
	$buffer .= "]<br /><br />";

	$buffer .= __('The rows (or columns) represent the position number of the component symbols. The first row number 0 is on the right', 'tb-enumerate') . " :<br />";
	for ($i = $i_nummaxrank; $i >= 0; $i--) {
	    $buffer .= "<b><i> $i  </i></b>";
	    if ($i > 0)
	     {
	      $buffer .= " | ";
	     }
	}

	$buffer .= "<br /><br />";
	$buffer .= __('To numerate for', 'tb-enumerate')." <b>0</b><sub>base 10</sub> ".__('to', 'tb-enumerate').
	" <b>$i_maxenumerate</b><sub>base 10</sub> ".__('to base', 'tb-enumerate')."  <b>".$i_base."</b> :";
	$buffer .= "<br /><br />";

	$i_toenumerate = 0;
	while ( $i_toenumerate <= $i_maxenumerate-1 )
	 {
		$i_numcurrentrank = 0;
		$a_nextrank[$i_numcurrentrank] = $this->nextSymbol ($a_number[$i_numcurrentrank], $a_symbol, $i_indicemax, $i_retained);

		while ( $i_numcurrentrank <= $i_nummaxrank ) 
		 {
		  $i_numcurrentrank ++;
		  if ($i_numcurrentrank <= $i_nummaxrank ) 
		   {
		    if ( $i_retained == 0 ) 
		     {
		      $a_nextrank[$i_numcurrentrank] = $a_number[$i_numcurrentrank];
		     }
		    else 
		     {
		      $buffer .= __('The following symbol in the left column is', 'tb-enumerate')." <span style=\"color:#BB0000\">".$i_retained."</span>.<br />";
		      $a_nextrank[$i_numcurrentrank] = $this->nextSymbol ($a_number[$i_numcurrentrank], $a_symbol, $i_indicemax, $i_retained);
		     }
		   }
		 }

		$s_parameter = implode ( array_reverse($a_nextrank) );
		$s_number = str_pad ( $s_parameter , $i_nummaxrank , "0" );
		$a_number = array_reverse(preg_split('//', $s_number, -1, PREG_SPLIT_NO_EMPTY));
		$i_toenumerate++;

		$buffer .= "<span style=\"background-color:#E0E8F1\"> <b><span style=\"color:#0000BB\">";
		$buffer .= "$s_number</span></b>  <sub>".$i_base."</sub> = ".$i_toenumerate."<sub>10</sub></span>";
		$buffer .= "<br />";
	 }

	return $buffer;
	}	

	function getView() {

		$content='
			'.__('Enter a number in the list and then click the enumerate button', 'tb-enumerate').'<br />                     
			<form action="" method="POST">
				<input type="hidden" name="action_field" id="action_field" value="1">
				<label>'.__('Number', 'tb-enumerate').'</label> : <input type="text" size="12" maxlength="10" name="number_field" id="number_field" value="'.htmlspecialchars($_POST['number_field']).'">&nbsp;
				<label>'.__('Base', 'tb-enumerate').'</label> : <input type="text" size="3" maxlength="2" name="base_field" id="base_field" value="'.htmlspecialchars($_POST['base_field']).'">&nbsp;
				<input type="submit" name="submit_button" id="submit_button" value="'.__('Enumerate', 'tb-enumerate').'">
			</form>
			<br />';

		if ($_POST['action_field'] == "1") {
		 $this->i_number = intval(htmlspecialchars($_POST['number_field']));
		 $this->base = intval(htmlspecialchars($_POST['base_field']));
		 $content=$this->makeToEnumerate($content);
		}

		return $content;
	}
}

?>
