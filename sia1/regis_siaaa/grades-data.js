// Grades data for all students
const studentGrades = {
    '0': { // Dela Cruz, Juan
        'im': { prelim: 2.50, midterm: 1.50, final: 5.00 },
        'web': { prelim: 2.00, midterm: 5.00, final: 2.50 },
        'sys': { prelim: 1.50, midterm: 1.75, final: 2.00 }
    },
    '1': { // James, LeBron Raymone
        'im': { prelim: 2.25, midterm: 2.00, final: 1.75 },
        'web': { prelim: 1.75, midterm: 2.50, final: 2.00 },
        'sys': { prelim: 2.00, midterm: 1.50, final: 2.25 }
    },
    '2': { // Contis, Paulo
        'im': { prelim: 1.75, midterm: 2.25, final: 2.00 },
        'web': { prelim: 2.50, midterm: 1.75, final: 2.25 },
        'sys': { prelim: 2.00, midterm: 2.50, final: 1.75 }
    },
    '3': { // Faulkerson, Richard Reyes
        'im': { prelim: 2.00, midterm: 1.75, final: 2.25 },
        'web': { prelim: 1.50, midterm: 2.00, final: 1.75 },
        'sys': { prelim: 2.25, midterm: 2.00, final: 1.50 }
    },
    '4': { // Villanueva, Moskov
        'im': { prelim: 1.50, midterm: 2.25, final: 2.00 },
        'web': { prelim: 2.25, midterm: 1.75, final: 2.50 },
        'sys': { prelim: 2.00, midterm: 1.50, final: 2.25 }
    },
    '5': { // Barrameda, Atlas
        'im': { prelim: 2.25, midterm: 2.00, final: 1.50 },
        'web': { prelim: 1.75, midterm: 2.25, final: 2.00 },
        'sys': { prelim: 2.50, midterm: 1.75, final: 2.25 }
    }
};

// Helper function to get empty grades object
function getEmptyGrades() {
    return {
        'im': { prelim: 0, midterm: 0, final: 0 },
        'web': { prelim: 0, midterm: 0, final: 0 },
        'sys': { prelim: 0, midterm: 0, final: 0 }
    };
}

// Function to get student grades safely
function getStudentGrades(studentId) {
    return studentGrades[studentId] || getEmptyGrades();
}

// Function to calculate grade status
function isPassingGrade(grade) {
    return grade <= 3.0;
}

// Function to show grades for a selected student
function showGrades(studentId, name, section) {
    document.getElementById('gradesView').style.display = 'block';
    document.getElementById('studentNameDisplay').textContent = name;
    document.getElementById('sectionDisplay').textContent = section;

    // Get the student's grades
    const grades = getStudentGrades(studentId);

    // Update Information Management grades
    updateGradeDisplay('im-prelim', grades.im.prelim);
    updateGradeDisplay('im-midterm', grades.im.midterm);
    updateGradeDisplay('im-final', grades.im.final);

    // Update Web Development grades
    updateGradeDisplay('web-prelim', grades.web.prelim);
    updateGradeDisplay('web-midterm', grades.web.midterm);
    updateGradeDisplay('web-final', grades.web.final);

    // Update System Integration grades
    updateGradeDisplay('sys-prelim', grades.sys.prelim);
    updateGradeDisplay('sys-midterm', grades.sys.midterm);
    updateGradeDisplay('sys-final', grades.sys.final);
}

// Function to update grade display with color coding
function updateGradeDisplay(elementId, grade) {
    const element = document.getElementById(elementId);
    element.textContent = grade.toFixed(2);
    element.className = 'grade-value ' + (grade > 3.0 ? 'fail' : 'pass');
} 