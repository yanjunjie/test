let reSlash = /^matchthis$/i
let reConstructor = new RegExp("^matchthis$", "i")
let pattern = "^matchthis$"
let flags = "i"
reConstructor = new RegExp(pattern, flags)

let theSpecialChars = "[({})]\\^$.|?*+"
let reMatchTheSpecialChars = /\[\(\{\}\)\]\\\^\$\.\|\?\*\+/
//console.log(reMatchTheSpecialChars.test(theSpecialChars))

// Three use cases
// Validation - is it a phone number with spaces and dashes?
let phoneNumber = "+46-702-11 abc 12 13" 
let isValidNumber = phoneNumber.match(/^[\+\d\-\s]+$/)
//console.log(`${phoneNumber} is ${isValidNumber ? 'valid' : 'INVALID'}`)

// Extraction - find occurences of david and how many times
let text = "david is writingdavid david code. david is in a video. david likes regex"
let extractDavid = text.match(/david/g)
//console.log(`${extractDavid.length} occurences of david in '${text}'`)

// Replacement
let replacedDavid = text.replace(/david/g, "devtips")
//console.log(replacedDavid)

// Highlight the matches of the pattern
function highlightString(content, result, pattern, cssClass) {
  pattern = pattern.replace(/^(\/)(.+)(\/[gmi]*)$/, "$2")
  
  var re = new RegExp(pattern, "g")  
  var text = content.value
  var matches = text.match(re)
  
  if (!matches) return;
  
  let pairing = []
  const unique = '§§§§§§§§§§§§'
  
  // Loop and replace each match with a unique pair ID
  matches.forEach((match, index) => {
    pairing.push({id: `${unique}${index}`, match: match})
    text = text.replace(match, `${unique}${index}`)
  })

  // Loop through the pair ids and replace them with a highlighted css class
  pairing.forEach((pair) => {
    let alter = `<mark ${(cssClass ? 'class="' + cssClass + '"' : '')}>${pair.match}</mark>`
    text = text.replace(pair.id, alter)
  })
  
  // Output the highlighted text to the result
  result.innerHTML = text
}

// On load
const patterns = document.querySelectorAll('.pattern')
patterns.forEach((pattern) => { 
  let input = pattern.querySelector('input.input')
  let button = pattern.querySelector('input[type=submit]')
  let content = pattern.querySelector('input.content')
  let result = pattern.querySelector('label')

  // Set the result to the contents
  result.innerHTML = content.value
  
  // Add regex function to the corresponding button.
  button.addEventListener('click', () => {
    result.innerHTML = content.value
    highlightString(
      content,
      result,
      input.value,
      'highlight'
    )
  })
  
  content.addEventListener('keyup', () => {
    result.innerHTML = content.value.trim()
  })
})