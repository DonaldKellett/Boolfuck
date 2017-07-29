<?php

/*
  Boolfuck Interpreter Test Cases
  For the actual interpreter please refer to `function.boolfuck.php`
*/

require 'function.boolfuck.php'; // Boolfuck Interpreter
require 'extras/function.brainfuck-to-boolfuck.php'; // Brainfuck to Boolfuck Converter (Extras)
require 'PHPTester-3.1.0/class.phptester.php'; // PHPTester Testing Framework

$test = new PHPTester;

$test->describe("The Interpreter", function () use ($test) {
  $test->it("should work for the \"Hello World\" program provided on the official website", function () use ($test) {
    $test->assert_equals(boolfuck(";;;+;+;;+;+;
+;+;+;+;;+;;+;
;;+;;+;+;;+;
;;+;;+;+;;+;
+;;;;+;+;;+;
;;+;;+;+;+;;
;;;;;+;+;;
+;;;+;+;;;+;
+;;;;+;+;;+;
;+;+;;+;;;+;
;;+;;+;+;;+;
;;+;+;;+;;+;
+;+;;;;+;+;;
;+;+;+;"), "Hello, world!\n", "The interpreter did not work with the code example provided on the official website");
  });
  $test->it("should work for a few more simple Boolfuck programs", function () use ($test) {
    // Echo until byte(0) encountered
    $test->assert_equals(boolfuck(">,>,>,>,>,>,>,>,>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>;>;>;>;>;>;>;>;>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>,>,>,>,>,>,>,>,>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]", "Codewars" . chr(0)), "Codewars");
    // Two numbers multiplier
    $test->assert_equals(boolfuck(">,>,>,>,>,>,>,>,>>,>,>,>,>,>,>,>,<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<<<<<<<<<[>]+<[+<]>>>>>>>>>[+]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>;>;>;>;>;>;>;>;<<<<<<<<", chr(8) . chr(9)), chr(72));
  });
  $test->it("should work for more Hello World programs", function () use ($test) {
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck("++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.")), "Hello World!");
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck("++++++++++[>+++>+++++++>+++++++++>++++++++++>+++++++++++<<<<<-]>>++.>>+.>--..+++.<<<<++.>>---.>>.+++.------.<-.<<<+.")), "Hello World!");
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck("++++++++[>++++[>++>+++>+++>+<<<<-]>+>+>->>+[<]<-]>>.>---.+++++++..+++.>>.<-.<.+++.------.--------.>>+.>++.")), "Hello World!\n");
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck(">++++++++[-<+++++++++>]<.>>+>-[+]++>++>+++[>[->+++<<+++>]<<]>-----.>->+++..+++.>-.<<+[>[+>+]>>]<--------------.>>.+++.------.--------.>+.>+.")), "Hello World!\n");
  });
  $test->it("should ignore all non-command characters", function () use ($test) {
    $test->assert_equals(boolfuck(";;;+;+;;+;+; Goodbye world
+;+;+ :p ;+;; TROLOLOLOL +;;+;
;;+; :D ;+ ;) +;;+;
;;+; (( ;+ GET REKT MUHAHAHA ;+; ))) ;+;        ((((
+;;;;NOOOOOOO+;+;;+;
;;+;DONT;+ REK;+; MAH+;;     PROGRAM
;;;Boolf**k is awesome;;+;+;;
+;;;+;Yes lets try some exclamation marks!!!!!+;;;+;
+;;;;+sldkfjdsk l d f j  mmxmn x ci    wour;+;;+;
;+;+;;sdfmsbdmsnbs+;;;+;
;;+;;+;sfsdd+;;+ertet;
rtyrtytry;;+;+;;+;;+;
+;+;;rtrtyrty;;+;rtrrtyy+;;
;+;rtyqeweqwq+;+;"), "Hello, world!\n", "The interpreter should ignore all non-command characters");
    $test->assert_equals(boolfuck(";;;+;+;;+;+; Goodbye world
+;+;+ :p ;+;; TR..O.L.O.L.O..LOL +;;+;
;;+;.... :..D ;+ ;) +;;+...;
;;+; (( ;+. ..GET REKT MUHAH..AHA ;+; ))) ;+;        ((((
+;;;-;-NOO-OO--OOO+;+;;+;
;;+;DONT;+ -REK;+; MAH+;;     PROGRAM
;;;Boolf**k-...--..--.-.....--...--- is -..--....---awesome;;+;+;;
+;;---..-.-.-..----....;+;Yes lets try.-.-.-.- some exclamation marks!!!!!+;;;+;
+;;;;+sldkf..-.-..--.-.jd.--..s-k.-.-.- l d f j  mmxmn x ci    wour;+;;+;
;+;+;;sdfms.--..-bdms.-.nbs+;;;+;
;;+;;+;sfsdd+;;+ertet;   ..-..-.--.-.---.-.-.-...--..----.-.-.-.-----.-..-...-.-.--
rtyrtytry;;+-;+-;;-+;;-+;
+;+;;rtrtyrty;;-+-;rtrrtyy-+-;;
;+--;rtyqeweqwq----+;+----;"), "Hello, world!\n", "The interpreter should not treat either of \".\" or \"-\" as command characters");
  });
  $test->it("should expand the tape in either direction when necessary", function () use ($test) {
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck("--<-<<+[+[<+>--->->->-<<<]>]<<--.<++++++.<<-..<<.<+.>>.>>.<<<.+++.>>.>>-.<<<+.")), "Hello, World!", "The tape did not expand to the left when necessary");
    $test->assert_equals(boolfuck("<<<<<<<<<<<<<<<<<<<<<<<<<<;;;+;+;;+;+;
+;+;+;+;;+;;+;
;;+;;+;+;;+;
;;+;;+;+;;+;
+;;;;+;+;;+;
;;+;;+;+;+;;
;;;;;+;+;;
+;;;+;+;;;+;
+;;;;+;+;;+;
;+;+;;+;;;+;
;;+;;+;+;;+;
;;+;+;;+;;+;
+;+;;;;+;+;;
;+;+;+;"), "Hello, world!\n", "The tape did not expand to the left when necessary");
    $test->assert_equals(boolfuck(str_repeat("<", 4e4) . ";;;+;+;;+;+;
+;+;+;+;;+;;+;
;;+;;+;+;;+;
;;+;;+;+;;+;
+;;;;+;+;;+;
;;+;;+;+;+;;
;;;;;+;+;;
+;;;+;+;;;+;
+;;;;+;+;;+;
;+;+;;+;;;+;
;;+;;+;+;;+;
;;+;+;;+;;+;
+;+;;;;+;+;;
;+;+;+;"), "Hello, world!\n", "The tape did not expand to the left when necessary");
    $test->assert_equals(boolfuck(";;;+;+;;+;+;
+;+;+;+;;+;;+;
;;+;;+;+;;+;
;;+;;+;+;;+;
+;;;;+;+;;+;
;;+;;+;+;+;;
;;;;;+;+;;
+;;;+;+;;;+;
+;;;;+;+;;+;
;+;+;;+;;;+;
;;+;;+;+;;+;
;;+;+;;+;;+;
+;+;;;;+;+;;
;+;+;+;>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>"), "Hello, world!\n", "The tape did not expand to the right when necessary");
    $test->assert_equals(boolfuck(";;;+;+;;+;+;
+;+;+;+;;+;;+;
;;+;;+;+;;+;
;;+;;+;+;;+;
+;;;;+;+;;+;
;;+;;+;+;+;;
;;;;;+;+;;
+;;;+;+;;;+;
+;;;;+;+;;+;
;+;+;;+;;;+;
;;+;;+;+;;+;
;;+;+;;+;;+;
+;+;;;;+;+;;
;+;+;+;" . str_repeat(">", 4e4)), "Hello, world!\n", "The tape did not expand to the right when necessary");
  });
  $test->it("should correctly multiply any two non-negative integers together for products up to and including 127", function () use ($test) {
    $test->assert_equals(boolfuck(">,>,>,>,>,>,>,>,>>,>,>,>,>,>,>,>,<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<<<<<<<<<[>]+<[+<]>>>>>>>>>[+]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>;>;>;>;>;>;>;>;<<<<<<<<", chr(3) . chr(5)), chr(15));
    $test->assert_equals(boolfuck(">,>,>,>,>,>,>,>,>>,>,>,>,>,>,>,>,<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<<<<<<<<<[>]+<[+<]>>>>>>>>>[+]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>;>;>;>;>;>;>;>;<<<<<<<<", chr(4) . chr(2)), chr(8));
    $test->assert_equals(boolfuck(">,>,>,>,>,>,>,>,>>,>,>,>,>,>,>,>,<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<<<<<<<<<[>]+<[+<]>>>>>>>>>[+]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>;>;>;>;>;>;>;>;<<<<<<<<", chr(1) . chr(127)), chr(127));
    $test->assert_equals(boolfuck(">,>,>,>,>,>,>,>,>>,>,>,>,>,>,>,>,<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<<<<<<<<<[>]+<[+<]>>>>>>>>>[+]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>;>;>;>;>;>;>;>;<<<<<<<<", chr(11) . chr(11)), chr(121));
    $test->assert_equals(boolfuck(">,>,>,>,>,>,>,>,>>,>,>,>,>,>,>,>,<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<<<<<<<<<[>]+<[+<]>>>>>>>>>[+]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>;>;>;>;>;>;>;>;<<<<<<<<", chr(16) . chr(6)), chr(96));
    $test->assert_equals(boolfuck(">,>,>,>,>,>,>,>,>>,>,>,>,>,>,>,>,<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]>[>]+<[+<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]<<<<<<<<<<<<<<<<<<<<<<<<<<[>]+<[+<]>>>>>>>>>[+]>>>>>>>>>>>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]<<<<<<<<<<<<<<<<<<+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]>>>>>>>>>>>>>>>>>>>;>;>;>;>;>;>;>;<<<<<<<<", chr($a = rand(0, 11)) . chr($b = rand(0, 11))), chr($a * $b));
  });
  $test->it("should properly interpret a Fibonacci program", function () use ($test) {
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]"), chr(10)), "1, 1, 2, 3, 5, 8, 13, 21, 34, 55");
  });
  $test->it('should set the value of the cell under the tape pointer to 0 when EOF is reached', function () use ($test) {
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck(',[.,]'), 'Codewars'), 'Codewars');
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck(',[.,]'), '@donaldsebleung'), '@donaldsebleung');
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck(',[.,]'), 'PHP'), 'PHP');
    $test->assert_equals(boolfuck(brainfuck_to_boolfuck(',[.,]'), 'Boolfuck'), 'Boolfuck');
  });
});

?>
