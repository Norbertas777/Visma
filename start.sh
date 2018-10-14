#!/bin/bash
# A menu driven shell script
## ----------------------------------
#  variables
# ----------------------------------
EDITOR=vim
RED='\033[0;41;30m'
STD='\033[0;0;39m'

# ----------------------------------
#  User defined functions
# ----------------------------------
pause(){
  read -p "Press [Enter] key to continue..." fackEnterKey
}

text(){
	echo "parsing text files"
	php ./index.php 0
    pause
}
word(){
	read -p "Enter the word you would like to hyphenate : " arg1
      php ./index.php 3 $arg1
    pause
}
db_word(){
	read -p "Enter the word you would like to hyphenate : " arg1
      php ./index.php 4 $arg1
    pause
}

# function to display menus
show_menus() {
	clear
	echo "~~~~~~~~~~~~~~~~~~~~~"
	echo " M A I N - M E N U"
	echo "~~~~~~~~~~~~~~~~~~~~~"
	echo "1. Parse all *.txt files"
	echo "2. Enter word"
	echo "3. Enter word that will be passed to DB. Will choose pattern source as database and hyphenate entered word!\n"
	echo "4. Exit"
}
read_options(){
	local choice
	read -p "Enter choice [ 1 - 4] " choice
	case $choice in
		1) text ;;
		2) word ;;
		3) db_word;;
		4) exit 0;;
		*) echo -e "${RED}Error...${STD}" && sleep 2
	esac
}

# ----------------------------------------------
#  Trap CTRL+C, CTRL+Z and quit singles
# ----------------------------------------------
trap '' SIGINT SIGQUIT SIGTSTP

# -----------------------------------
#  Main logic - infinite loop
# ------------------------------------
while true
do
	show_menus
	read_options
done