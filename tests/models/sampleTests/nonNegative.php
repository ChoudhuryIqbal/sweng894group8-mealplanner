<?php
// Float sample tests
// Notes:
// - Adjust longVariableName max to length + 1, and method name to max length
// Copy below this line --------------------------------------------------------


//////////////
// Variable //
//////////////

public function testVariableCannotBeNegative(){
    $negativeVariable = -1;
    $this->expectException(\Exception::class);
    $this->cut->setVariable($negativeVariable);
}
