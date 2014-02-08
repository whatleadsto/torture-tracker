#
# get-country-prob.sh,  8 Feb 14

# Extract Country name and problem from scrape of Amnesty open/closed torture cases

#
# usage: get-country-prob.sh file.html > out.csv

cat "$1" | grep -E "confluenc|<li>" | \
sed -e "s/<li>//" | sed -e "s/<\/li>//" | sed -e "s/<\/a>.*$//" | sed -e "s/^.*>//"  | sed -e "s/	/# /" | \
awk -e ' \
NF == 0 { \
	next \
	} \
 \
$1 == "#" { \
	$1="" ; \
	printf(",%s", $0) ; \
	next \
	} \
 \
	{ \
	printf("\n%s", $0) ; \
	next \
	}'

