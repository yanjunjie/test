// Classic first/last name switcharoo regex replace example
let firstThenLast = "Zara Larsson"
let getFirstAndLast = /(\w+) (\w+)/
firstThenLast.match(getFirstAndLast) //?
let lastCommaFirst = firstThenLast.replace(getFirstAndLast, "$2, $1") //?

// Capturing parentheses
let message = "MPJ hosts DevTips"
let host = message.match(/(dah?vid|mpj) hosts devtips/i)[1] //?

// Capturing with alternation
let country = "United Kingdom"
let rightCountry = country.match(/(sweden|germany|brazil)/i) //?

// Use case with capturing parentheses, lists the new hosts from file
const csv = `Date,Host
2018-04-20,Travis
2018-04-27,David
2018-05-25,David
2018-06-01,MPJ`

let dateAndHost = /^(\d{4}-\d{2}-\d{2}),(obama|travis|mpj)$/i

let newHostsWhen = csv
  .split("\n") //?
  .filter(line => {
    return line.match(dateAndHost) //?
  })
  .map(line => line.replace(dateAndHost, "$2 hosted DevTips on $1"))
  .join(". ")
newHostsWhen

// Non-capturing parentheses
let input = "David hosts DevTips"
let incorrectInput = "Trump hosts White House"

let extractChannelIfCorrectHost = /(?:dah?vid|mpj|sean evans) hosts (.+)/i
let channel = input.match(extractChannelIfCorrectHost)[1] //?
channel = incorrectInput.match(extractChannelIfCorrectHost) //?
channel = "MPJ hosts Fun Fun Function".match(extractChannelIfCorrectHost)[1] //?
channel = "Sean Evans hosts Hot Ones".match(extractChannelIfCorrectHost)[1] //?