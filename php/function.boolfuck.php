<?php

/*
  Boolfuck Interpreter
  (c) Donald Leung
  FreeBSD 2-Clause Licensed
*/

function boolfuck(string $code, string $input = ""): string {
  // Convert character input into bits.  Each byte is read in little-endian order
  $bit_input = implode(array_map(function ($c) {return strrev(str_repeat("0", 8 - strlen($s = decbin(ord($c)))) . $s);}, str_split($input)));
  // Initialize Tape (can be extended indefinitely in both directions)
  $tape = [0];
  // Pointer
  $pointer = 0;
  // Read bit input left to right
  $input_index = 0;
  // Initialize bit output
  $bit_output = "";
  for ($i = 0; $i < strlen($code); $i++) {
    switch ($code[$i]) {
      case "+":
      // Flip the bit under the pointer
      $tape[$pointer] = intval(!$tape[$pointer]);
      break;
      case ",":
      // Read a bit from the bit input into the current bit under the pointer
      $tape[$pointer] = isset($bit_input[$input_index++]) ? $bit_input[$input_index - 1] : 0;
      break;
      case "<":
      // Moves the pointer left by 1 bit.  Expand tape to the left when necessary
      if (!isset($tape[--$pointer])) $tape[$pointer] = 0;
      break;
      case ">":
      // Moves the pointer right by 1 bit.  Expand tape to the right when necessary
      if (!isset($tape[++$pointer])) $tape[$pointer] = 0;
      break;
      case ";":
      // Output the current bit under the pointer
      $bit_output .= $tape[$pointer];
      break;
      case "[":
      // Skip to matching "]" if bit under current pointer is 0
      if ($tape[$pointer] === 0) {
        $unmatched = 1;
        while ($unmatched) {
          if ($code[++$i] === "[") $unmatched++;
          if ($code[$i] === "]") $unmatched--;
        }
      }
      break;
      case "]":
      // Jump backwards to matching "[" if bit under current pointer is nonzero (i.e. 1)
      if ($tape[$pointer] !== 0) {
        $unmatched = 1;
        while ($unmatched) {
          if ($code[--$i] === "[") $unmatched--;
          if ($code[$i] === "]") $unmatched++;
        }
      }
      break;
    }
  }
  // Convert bit output into character output
  $chars = array_map(function ($b) {return chr(bindec(strrev($b . str_repeat("0", 8 - strlen($b)))));}, str_split($bit_output, 8));
  // Construct output string from character array (not sure why implode() doesn't work properly when I try to convert the bit output in one step and return it straight away)
  $output = "";
  foreach ($chars as $char) $output .= $char;
  return $output;
}

?>
