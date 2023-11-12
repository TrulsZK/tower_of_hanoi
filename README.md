# Tower of Hanoi

Tower of Hanoi game made for my website using PHP, HTML, CSS, and JavaScript.

# Gameplay

- The game consists of 3 towers, Tower A, B, and C and a number of disks placed on Tower A. The disks are placed from largest (higher number) on the bottom to the smallest (lower number) on top.
- The objective of the game is to move all disks to Tower C (on the right side).
- The user can not place a larger disk on top of a smaller disk.
- Use the buttons om the page to move the disks between the towers.
- The game calculates the minimum required mov.es and counts the number of moves made by the user and displays this.
- The user will be alerted if they try to make an invalid move.
- The user will be alerted when the game completes and the moves used and minimum required.

# Logic

The game reads the property ```disks``` and the game uses PHP to render the HTML page with the selected number of disks.

The HTML page consists of 3 unordered lists. There is one for each tower, ```towerA```, ```towerB```, and ```towerC```. Tower A starts with a list element for each disk, ```disk1```, ```disk2```, etc. The remaining 2 towers consists of the same number of placeholder list items, ```placeholderB1```, ```placeholderB2```, etc.

When the user moves a disk the function ```moveDisk``` get called with the source and destination towers as parameters. The function does the following:

- Verifies that the game is not completed by calling the ```checkComplete``` helper function. This checks if the top item in Tower C ```towerC``` is Disk 1 ```disk1```.
- Verifies that the move is valid by calling the ```verifyMove``` helper function. This verifies that there is a disk in the source table and that is it smaller than the top disk in the destination tower.
- Increments the move counter by calling the ```incrementCounter``` helper function.
- Finds the top disk item in the source list and removes it.
- Finds the bottom placeholder item in the destination list and removes it.
- Adds the placeholder item to the top of the source list.
- Adds the disk item to the destination list on top of any existing disks, or on the bottom if there are none in the destination tower.
- Checks if the game is complete after this move is complete by calling the ```checkComplete``` helper function. This checks if the top item in Tower C ```towerC``` is Disk 1 ```disk1```.

# TrulsZK Website / Live game

The game is in production on my website at https://trulszk.com/OtherPage/TowerOfHanoi.php?disks=3 where the property disk is the number of disks.
