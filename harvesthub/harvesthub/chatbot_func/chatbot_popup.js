function toggleChatbot() {
    var chatbot = document.getElementById('chatbot-container');
    showMenu(); 
    chatbot.style.display = chatbot.style.display === 'none' ? 'block' : 'none';
}

function clearMessages() {
    var messagesContainer = document.getElementById('chatbot-messages');
    messagesContainer.innerHTML = ''; 
}

function sendMessage() {
    var input = document.getElementById('chatbot-input');
    var message = input.value.trim();
    if (message) {
        addMessage(message, 'user-message');
        input.value = '';
        handleUserInput(message); 
    }
}

function addMessage(text, className) {
    var messagesContainer = document.getElementById('chatbot-messages');
    var messageDiv = document.createElement('div');
    messageDiv.className = 'chatbot-message ' + className;
    messageDiv.textContent = text;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function showMenu() {
    addMessage("Welcome to the EcoChat become more eco friendly! Choose an option:\n1. Get Tips\n2. Take a Quiz\n3. Get a Recipe", 'chatbot-message');
}

var tips = [
    "Use reusable bags instead of plastic ones.",
    "Turn off lights when not in use.",
    "Plant a tree or maintain a garden.",
    "Recycle paper, glass, and plastic regularly.",
    "Use public transport or carpool when possible.",
    "Reduce water waste by fixing leaks.",
    "Shop locally to reduce transportation emissions.",
    "Use energy-efficient appliances.",
    "Cut down on meat consumption to reduce carbon footprint.",
    "Avoid single-use plastics."
];

var quizQuestions = [
    { question: "What reduces your carbon footprint the most?", options: ["Recycling", "Planting trees", "Using public transport"], answer: 2 },
    { question: "Which is the most energy-efficient household appliance?", options: ["Dishwasher", "LED bulb", "Microwave"], answer: 1 },
    { question: "What helps to save water?", options: ["Shorter showers", "Leaving the tap running", "Watering the garden at noon"], answer: 0 },
];

var currentQuestion = 0;
var score = 0;

function askQuestion() {
    var question = quizQuestions[currentQuestion];
    addMessage(question.question, 'chatbot-message');
    question.options.forEach((option, index) => {
        addMessage((index + 1) + ". " + option, 'chatbot-message');
    });
}

function checkAnswer(message) {
    var correctAnswer = quizQuestions[currentQuestion].answer;
    if (parseInt(message) === correctAnswer + 1) {
        score++;
        addMessage("Correct!", 'chatbot-message');
    } else {
        addMessage("Oops! The correct answer was " + (correctAnswer + 1), 'chatbot-message');
    }

    currentQuestion++;
    if (currentQuestion < quizQuestions.length) {
        askQuestion();
    } else {
        addMessage("Quiz complete! Your score: " + score + "/" + quizQuestions.length, 'chatbot-message');
        showMenu(); 
        currentQuestion = 0; 
        score = 0;
    }
}

var recipes = [
    { name: "Vegan Pasta", ingredients: ["Pasta", "Tomato sauce", "Vegetables"], instructions: "Cook pasta, add sauce and veggies." },
];

function showRandomRecipe() {
    var selectedRecipe = recipes[Math.floor(Math.random() * recipes.length)];
    addMessage("Recipe: " + selectedRecipe.name, 'chatbot-message');
    addMessage("Ingredients: " + selectedRecipe.ingredients.join(", "), 'chatbot-message');
    addMessage("Instructions: " + selectedRecipe.instructions, 'chatbot-message');
}

function handleUserInput(message) {
    if (message === "1") {
        addMessage("Here are some eco-friendly tips...", 'chatbot-message');
        var selectedTips = tips.sort(() => 0.5 - Math.random()).slice(0, 3);
        selectedTips.forEach(tip => addMessage(tip, 'chatbot-message'));
    } else if (message === "2") {
        addMessage("Starting eco-friendly quiz...", 'chatbot-message');
        askQuestion();
    } else if (message === "3") {
        addMessage("Here's a random recipe for you...", 'chatbot-message');
        showRandomRecipe();
    } else {
        addMessage("Sorry, I didn't understand that. Please choose 1 for tips, 2 for a quiz, or 3 for a recipe.", 'chatbot-message');
    }
}
