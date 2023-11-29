function addQuestion() {
    const questionNumber = document.getElementById('questions').childElementCount + 1;
    const questionDiv = document.createElement('div');
    questionDiv.innerHTML = `
        <h3>Question ${questionNumber}</h3>
        <label for="questionText${questionNumber}">Question Text:</label>
        <input type="text" id="questionText${questionNumber}" name="questionText${questionNumber}" required>
        <br>
        <label for="option${questionNumber}">Options:</label>
        <input type="text" id="option${questionNumber}" name="option${questionNumber}" required>
        <button type="button" onclick="addOption(this)">Add Option</button>
        <br>
        <label for="correctOption${questionNumber}">Correct Option:</label>
        <select id="correctOption${questionNumber}" name="correctOption${questionNumber}" required>
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
            <option value="option4">Option 4</option>
        </select>
    `;
    document.getElementById('questions').appendChild(questionDiv);
}

function addOption(element) {
    const optionNumber = element.parentElement.getElementsByTagName('input').length + 1;
    const optionInput = document.createElement('input');
    optionInput.type = 'text';
    optionInput.id = `option${optionNumber}`;
    optionInput.name = `option${optionNumber}`;
    optionInput.required = true;
    element.parentElement.appendChild(optionInput);

    const correctOptionSelect = element.parentElement.getElementsByTagName('select')[0];
    const newOption = document.createElement('option');
    newOption.value = `option${optionNumber}`;
    newOption.text = `Option ${optionNumber}`;
    correctOptionSelect.appendChild(newOption);
}