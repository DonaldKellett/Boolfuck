/*
  Boolfuck Interpreter
  (c) Donald Leung
  FreeBSD 2-Clause Licensed
*/

function boolfuck(code, input = "") {
  // Initialize tape (can be extended infinitely in both directions)
  var tape = [0];
  // Pointer
  var pointer = 0;
  // Convert input into corresponding bytes then into a string of bits
  var bitInput = input.split("").map(c => c.charCodeAt().toString(2)).map(b => "0".repeat(8 - b.length) + b).map(b => b.split("").reverse().join(""));
  bitInput = bitInput.join("");
  // Read bits from left to right one by one
  var bitIndex = 0;
  // Output (in terms of bits - will have to convert into character output at a later stage)
  var bitOutput = "";
  for (var i = 0; i < code.length; i++) {
    // Loop through each character of the Boolfuck program
    switch (code[i]) {
      case "+":
      // Flip the bit
      tape[pointer] = +!tape[pointer];
      break;
      case ",":
      // Read one bit from the converted input into the current cell
      tape[pointer] = bitInput[bitIndex++] === undefined ? 0 : parseInt(bitInput[bitIndex - 1]);
      break;
      case ";":
      // Output the bit
      bitOutput += tape[pointer];
      break;
      case "<":
      // Move the pointer left by 1 bit.  Expand the tape to the left if necessary
      pointer--;
      if (pointer < 0) {
        tape = [0].concat(tape);
        pointer++;
      }
      break;
      case ">":
      // Move the pointer right by 1 bit.  Expand the tape to the right if necessary
      pointer++;
      if (pointer >= tape.length) tape.push(0);
      break;
      case "[":
      if (tape[pointer] === 0) {
        // Unmatched opening bracket found.  Find matching closing bracket
        var unmatched = 1;
        while (unmatched > 0) {
          i++;
          if (code[i] === "[") unmatched++;
          if (code[i] === "]") unmatched--;
        }
      }
      break;
      case "]":
      if (tape[pointer] === 1) {
        // Unmatched closing bracket found.  Find matching opening bracket
        var unmatched = 1;
        while (unmatched > 0) {
          i--;
          if (code[i] === "[") unmatched--;
          if (code[i] === "]") unmatched++;
        }
      }
      break;
    }
  }
  // Separate the bit output into bytes
  var bytes = [];
  for (var i = 0; i < bitOutput.length; i++) bytes[~~(i / 8)] = bytes[~~(i / 8)] ? bytes[~~(i / 8)] + bitOutput[i] : bitOutput[i];
  bytes[bytes.length - 1] += "0".repeat(8 - bytes[bytes.length - 1].length);
  bytes = bytes.map(b => b.split("").reverse().join(""));
  // Convert bytes into characters
  var characters = bytes.map(b => String.fromCharCode(parseInt(b, 2)));
  // Convert characters into output string
  var output = characters.join("");
  return output;
}
