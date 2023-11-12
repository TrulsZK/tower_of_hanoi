<?php

$numberOfDisks = $_GET["disks"];

if ($numberOfDisks < 1) {
$numberOfDisks = 1;
}

if ($numberOfDisks > 16) {
$numberOfDisks = 16;
}

$minimumNumberOfMoves = 2 ** intval($numberOfDisks) - 1;

function numberToDisk($number) {

    $org_numbers = $number;
    $minuses = "";

    for ($i = 1; $i <= $number; $i++) {
        $minuses = $minuses . "-";
        
}

$output = $minuses . $org_numbers . $minuses;

return $output;

}

?>

<style>

.list-container {
    display: flex;
    justify-content: space-around;
    align-items: start;
    min-height: 100px;
}

.list-container ul {
    list-style-type: none;
    padding: 0;
    text-align: center;
    min-width: 20%;
    margin: 0 1%;
}

.list-container li {
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 5px;
}

button {
    padding: 10px 10px;
    border: 2px solid #ffffff;
    border-radius: 4px;
    background-color: #000022;
    color: #ffffff;
}

</style>

<script>

var currentMoves = 0;

function moveDisk(source, destination) {

    // Check if complete
    var ifCompletePreCheck = checkComplete();
    if (ifCompletePreCheck == true) {
        return;
    }

    // Verify move is valid
    var validMove = verifyMove(source, destination);
    if (validMove == false) {
        return;
    }

    // Increment moves
    incrementCounter();

    // Get lists from function
    var sourceList = document.getElementById(source);
    var destinationList = document.getElementById(destination);

    // Find top disk item in source list
    var itemToMoveSource = null;
    var itemToMoveSourcePosition = 0;
    for (var i = 0; i <= sourceList.children.length - 1; i++) {
        var item = sourceList.children[i];
        if (item.id.startsWith('disk')) {
            itemToMoveSource = item;
            itemToMoveSourcePosition = i;
            break;
        }
    }

    // Remove disk from source
    sourceList.removeChild(itemToMoveSource);

    // Find bottom placeholder item in destination list
    var itemToMoveDestination = null;
    var itemToMoveDestinationPosition = 0;
    for (var i = destinationList.children.length - 1; i >= 0; i--) {
        var item = destinationList.children[i];
        if (item.id.startsWith('placeholder')) {
            itemToMoveDestination = item;
            itemToMoveDestinationPosition = i;
            break;
        }
    }

    // Remove placeholder from destination 
    destinationList.removeChild(itemToMoveDestination);

    // Add placeholder to source
    var nodeSource = document.createElement("li");
    nodeSource.id = itemToMoveDestination.id;
    var textnodeSource = document.createTextNode(itemToMoveDestination.innerHTML);
    nodeSource.appendChild(textnodeSource);
    var listSource = document.getElementById(sourceList.id);
    listSource.insertBefore(nodeSource, listSource.children[0]);

    // Add disk to destination
    var nodeDestination = document.createElement("li");
    nodeDestination.id = itemToMoveSource.id;
    var textnodeDestination = document.createTextNode(itemToMoveSource.innerHTML);
    nodeDestination.appendChild(textnodeDestination);
    var listDestination = document.getElementById(destinationList.id);
    listDestination.insertBefore(nodeDestination, listDestination.children[itemToMoveDestinationPosition]);

    // Check if complete post move
    checkComplete();

    return;

}

function verifyMove(source, destination) {

    // Get lists from function
    var sourceList = document.getElementById(source);
    var destinationList = document.getElementById(destination);
    
    // Find top disk item in source list
    var itemToMoveSource = null;
    var itemToMoveSourcePosition = 0;
    for (var i = 0; i <= sourceList.children.length - 1; i++) {
        var item = sourceList.children[i];
        if (item.id.startsWith('disk')) {
            itemToMoveSource = item;
            itemToMoveSourcePosition = i;
            break;
        }
    }

    var topDiskSourceInt = 0;
    if (itemToMoveSource != null) {
        topDiskSourceInt = getInteger(itemToMoveSource.id)
    } else { // Alert if no disk to move in source list
        alert('Invalid move: No disk to move from Tower ' + getTowerString(sourceList.id));
        return false;
    }

    // Find top disk item in destination list
    var itemToMoveDestination = null;
    var itemToMoveDestinationPosition = 0;
    for (var i = 0; i <= destinationList.children.length - 1; i++) {
        var item = destinationList.children[i];
        if (item.id.startsWith('disk')) {
            itemToMoveDestination = item;
            itemToMoveDestinationPosition = i;
            break;
        }
    }

    var topDiskDestinationInt = 0;
    if (itemToMoveDestination != null) {
        topDiskDestinationInt = getInteger(itemToMoveDestination.id)
    }

    // Check if source disk is larger than destination
    if (topDiskSourceInt > topDiskDestinationInt && topDiskDestinationInt != 0) {
        alert('Invalid move: You can not place a larger disk (Disk ' + topDiskSourceInt + ') on top of a smaller (Disk ' + topDiskDestinationInt + ')')
        return false;
    }

    return true;

}

function checkComplete() {

    var towerList = document.getElementById('towerC');
    var item = towerList.children[0];

    if (item.id == 'disk1') {
        alert('Complete: You completed in ' + currentMoves + ' moves of minimum <?php echo($minimumNumberOfMoves); ?> moves');
        return true;
    }

    return false;

}

function getInteger(string) {
    
    var matches = string.match(/\d+/);
    if (matches) {
        return parseInt(matches[0], 10);
    }
    return 0;

}

function getTowerString(string) {

    var tower = '';
    if (string.startsWith('tower')) {
        tower = string.substring(5, 6);
    }
    return tower;

}

function incrementCounter() {

    currentMoves = currentMoves + 1;
    document.getElementById("currentMovesText").innerHTML = 'Current moves: ' + currentMoves;

}

function refreshPage(disks) {

    var queryString = '?disks=' + disks;
    window.location.href = window.location.origin + window.location.pathname + queryString;

}

</script>

<h1>Tower of Hanoi</h1>

<p>Move all disks to Tower C. Use buttons to move disks between the towers.</p>

<p>Number of Disks:<br>
<button onclick="refreshPage('1')">1</button>
<button onclick="refreshPage('2')">2</button>
<button onclick="refreshPage('3')">3</button>
<button onclick="refreshPage('4')">4</button>
<button onclick="refreshPage('5')">5</button>
<button onclick="refreshPage('6')">6</button>
<button onclick="refreshPage('7')">7</button>
<button onclick="refreshPage('8')">8</button>
<button onclick="refreshPage('9')">9</button>
<button onclick="refreshPage('10')">10</button>
<button onclick="refreshPage('11')">11</button>
<button onclick="refreshPage('12')">12</button>
<button onclick="refreshPage('13')">13</button>
<button onclick="refreshPage('14')">14</button>
<button onclick="refreshPage('15')">15</button>
<button onclick="refreshPage('16')">16</button>

<br>
<br>

<p id="numberOfDisksText">Number of Disks: <?php echo($numberOfDisks); ?></p>
<p id="currentMovesText">Current moves: 0</p>
<p id="minimumMovesText">Minimum moves required: <?php echo($minimumNumberOfMoves); ?></p>
<br>

<div class="list-container">
    <button onclick="moveDisk('towerA', 'towerB')">A to B</button>
    <button onclick="moveDisk('towerA', 'towerC')">A to C</button>
    <button onclick="moveDisk('towerB', 'towerA')">B to A</button>
    <button onclick="moveDisk('towerB', 'towerC')">B to C</button>
    <button onclick="moveDisk('towerC', 'towerA')">C to A</button>
    <button onclick="moveDisk('towerC', 'towerB')">C to B</button>
</div>

<div class="list-container">
    <h1>Tower A</h1>
    <h1>Tower B</h1>
    <h1>Tower C</h1>
</div>

<div class="list-container">
    <ul id="towerA">
        <?php for ($i = 1; $i <= $numberOfDisks; $i++) {
            echo "<li id='disk" . $i . "'>" . numberToDisk($i) . "</li>";
        } ?>
    </ul>

    <ul id="towerB">
        <?php for ($i = 1; $i <= $numberOfDisks; $i++) {
            echo "<li id='placeholderB" . $i . "'>-</li>";
        } ?>
    </ul>

    <ul id="towerC">
        <?php for ($i = 1; $i <= $numberOfDisks; $i++) {
            echo "<li id='placeholderC" . $i . "'>-</li>";
        } ?>
    </ul>

</div>
