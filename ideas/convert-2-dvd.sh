#!/bin/sh

echo "Remark out exit when you know what the script does."
exit 0

echo "... Step 1 let us convert the video files to .mpeg files."
rm -f ./mpegs/*.mpeg
find ../ -type f -name *mp4 | awk -F\/ '{print "avconv -i \""$0"\" -target ntsc-dvd ./mpegs/\""substr($4,1,length($4)-4)".mpeg\""}' | sh
echo "Done with Step 1."

echo "... Step 2 let us setup an xml file for the dvd."
cat dvdauthor.header > ./mpegs/dvdauthor.xml
find ./mpegs/ -type f -name "*.mpeg" | sort | awk -F/ '{print "cat dvdauthor.body | sed s/VIDEO/\""$3"\"/ >> ./mpegs/dvdauthor.xml"}' | sh
cat dvdauthor.footer >> ./mpegs/dvdauthor.xml
cp padding.mpeg ./mpegs/
echo "Done with Step 2."

echo "... Step 3 let us generate the dvd setup in the ./dvd directory."
rm -rf ./mpegs/dvd/*
dvdauthor -o ./mpegs/dvd/ -x ./mpegs/dvdauthor.xml
echo "Done with Step 3."

echo "... Step 4 let us generate the iso file."
genisoimage  -dvd-video -v -o ./ts-yt-dl.iso ./mpegs/dvd/
echo "Done with Step 4."

