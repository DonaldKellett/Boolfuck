<?php

/*
  Brainfuck to Boolfuck Converter
  (c) Donald Leung
  FreeBSD 2-Clause Licensed
*/

function brainfuck_to_boolfuck(string $brainfuck): string {
  return implode(array_map(function (string $command): string {
    return [
      "+" => ">[>]+<[+<]>>>>>>>>>[+]<<<<<<<<<",
      "-" => ">>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+]<<<<<<<<<",
      "<" => "<<<<<<<<<",
      ">" => ">>>>>>>>>",
      "," => ">,>,>,>,>,>,>,>,<<<<<<<<",
      "." => ">;>;>;>;>;>;>;>;<<<<<<<<",
      "[" => ">>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>[+<<<<<<<<[>]+<[+<]",
      "]" => ">>>>>>>>>+<<<<<<<<+[>+]<[<]>>>>>>>>>]<[+<]"
    ][$command];
  }, str_split(preg_replace('/[^+\-<>.,\[\]]/', "", $brainfuck))));
}

?>
