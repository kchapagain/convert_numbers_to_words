<?php

//get user input
$number_to_convert = $_GET['number'];


//display converted value
echo factor_input_number($number_to_convert);

function factor_input_number($number_to_convert) 
{
    
    $dollor =0;
    $cents = 0;
    $result ='';
    $error = '';

    
    //validate input value
    //if its not number  display error message and exit
    
    if(!is_numeric($number_to_convert) || ($number_to_convert < 0 - PHP_INT_MAX)) {
      
        $error = '<p style=\'color:crimson;\'>Error!! Please check input vaue</p>';
        return $error;
    } //end if
    
    //if entere value is greater then quintillion display error message 
    //notifying user conversion unsuccessfull
    if($number_to_convert > 1000000000000000000){
        $error = '<p style=\'color:crimson;\'>Opps!! Conversion doesnot support value over one quintillion      
                 (1000000000000000000). </p>';
        return $error;
    }
    
    //breakup $number_to_convert and store in dollor and cents variable
    
    //check if input variable has dollor and cents
    
        if (strpos($number_to_convert, '.') !== false) {
            
            $break_up_value = explode('.', $number_to_convert);
            
            $dollor = abs($break_up_value[0]);
            $cents = $break_up_value[1];
            
        } else {
            $dollor = abs($number_to_convert);
        }
    
        //return value
    
    //display  in red if entered value is negative
    if($number_to_convert < 0) {
            $result .= '<p style=\'color:crimson;\'>';
    } else {
        $result .= '<p>';
    }
        
    //display converted value
    $result .=  $number_to_convert. ' = ';
    
        if($dollor != 0)  
            $result .= convert_amount_towords($dollor). ' dollors ';
        
        if(($dollor !=0) && ($cents != 0))
            $result .= ' and ';
    
        if($cents != 0)
            $result.=  convert_amount_towords($cents) . ' cents ';
    
        $result .='</p>';
    
    
    return strtoupper($result);
    
}//end factorInputNumber


function convert_amount_towords($number){
    
$ones = array(
    0 => 'zero',
    1 => 'one',
    2 => 'two',
    3 => 'three',
    4 => 'four',
    5 => 'five',    
    6 => 'six',
    7 => 'seven',
    8 => 'eight',
    9 => 'nine',
    10 => 'ten',
    11 => 'eleven',
    12 => 'twelve',
    13 => 'thirteen',
    14 => 'fourteen',
    15 => 'fifteen',
    16 => 'sixteen',
    17 => 'seventeen',
    18 => 'eighteen',
    19 => 'ninteen'
);
    
$tens = array(
    20 => 'tewnty',
    30 => 'thrity',
    40 => 'fourty',
    50 => 'fifty',
    60 => 'sixty',
    70 => 'seventy',
    80 => 'eighty',
    90 => 'ninty'
);
    
$hundred_and_more = array(
    100 => 'hundred',
    1000 => 'thousand',
    1000000 => 'million',
    1000000000 => 'billion',
    1000000000000 => 'trillion',
    1000000000000000 => 'quadrillion',
    1000000000000000000 => 'quintillion'
); 
    $string = '';
        
    switch($number) {
        
        case $number <= 19:
            $string = $ones[$number] ;
            break;
        
        case $number < 100:
            $string = convert_less_then_hundred_to_words($number, $tens, $ones);
            break;
        
        case $number < 1000:
            $string = convert_less_then_thousand_to_words($number, $tens, $ones, $hundred_and_more);
            break;        
        
        
        default:
            $string = convert_more_then_thousand_to_words($number,  $tens,  $ones,  $hundred_and_more);
            break;
    }//end switch case
    
    
    return $string;
    
} //end convert_amount_towords 

function convert_less_then_hundred_to_words($number, Array $tens, Array $ones) {
    
        $string = '';
    
        $ten   = ((int) ($number / 10)) * 10;
    
        $has_one  = $number % 10;
    
        $string .= $tens[$ten] . '-';

        if ($has_one ) {
             $string .= $ones[$has_one];
        }

        return $string;
}

function convert_less_then_thousand_to_words($number, Array $tens, Array $ones, Array $hundred_and_more){
    
        $string = '';
    
        $hundreds  = $number / 100;
    
        $has_remainder = $number % 100;

        $string = $ones[$hundreds]  . ' hundred '; 

        if ($has_remainder) {
                $string .=  ' and ' . convert_amount_towords($has_remainder);
            }

        return $string;
}

function convert_more_then_thousand_to_words($number, Array $tens, Array $ones, Array $hundred_and_more) {
    
        $string = '';
    
        $get_base_unit = pow(1000, floor(log($number, 1000)));

        $has_remainder = $number % $get_base_unit;
    
        $number_base_units = (int) ($number / $get_base_unit);

        $string = convert_amount_towords($number_base_units) . '-' . $hundred_and_more[$get_base_unit]. ' ';

        if ($has_remainder) {
            
            $string .= ' and '. convert_amount_towords($has_remainder);
        }
    
    return $string;
  }

