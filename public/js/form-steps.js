function nextStep(stepNumber) {
    hideAllSteps();
    document.getElementById(`step${stepNumber}`).style.display = 'block';
}

function previousStep(stepNumber) {
    hideAllSteps();
    document.getElementById(`step${stepNumber}`).style.display = 'block';
}

function hideAllSteps() {
    const steps = document.querySelectorAll('.step');
    steps.forEach(step => {
        step.style.display = 'none';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    // Initialiser le formulaire pour montrer la première étape
    document.getElementById('step1').style.display = 'block';
});
