-- First, let's create a procedure to add subjects if they don't exist
DELIMITER //

CREATE PROCEDURE add_default_grades(IN p_student_id INT)
BEGIN
    -- First Semester Subjects
    INSERT IGNORE INTO grades (student_id, subject, semester, prelim, midterm, finals, remarks)
    VALUES 
    (p_student_id, 'Information Management (CCS2205)', '1st', 0, 0, 0, 'FAILED'),
    (p_student_id, 'Web Development (WEB 2)', '1st', 0, 0, 0, 'FAILED'),
    (p_student_id, 'System Integration and Architecture (CCS2111)', '1st', 0, 0, 0, 'FAILED'),
    (p_student_id, 'Software Engineering (SE)', '1st', 0, 0, 0, 'FAILED'),
    (p_student_id, 'Object Oriented Programming (OOP)', '1st', 0, 0, 0, 'FAILED');

    -- Second Semester Subjects
    INSERT IGNORE INTO grades (student_id, subject, semester, prelim, midterm, finals, remarks)
    VALUES 
    (p_student_id, 'Mobile Application Development (MAD)', '2nd', 0, 0, 0, 'FAILED'),
    (p_student_id, 'Database Management Systems (DBMS)', '2nd', 0, 0, 0, 'FAILED'),
    (p_student_id, 'Network Administration (NET)', '2nd', 0, 0, 0, 'FAILED'),
    (p_student_id, 'Cybersecurity Fundamentals (CSF)', '2nd', 0, 0, 0, 'FAILED'),
    (p_student_id, 'Cloud Computing (CC)', '2nd', 0, 0, 0, 'FAILED');
END //

DELIMITER ;

-- Add default subjects for all existing students
INSERT INTO grades (student_id, subject, semester, prelim, midterm, finals, remarks)
SELECT 
    s.id,
    sub.subject_name,
    sub.semester,
    0, 0, 0,
    'FAILED'
FROM 
    students s
CROSS JOIN (
    SELECT 'Information Management (CCS2205)' as subject_name, '1st' as semester
    UNION SELECT 'Web Development (WEB 2)', '1st'
    UNION SELECT 'System Integration and Architecture (CCS2111)', '1st'
    UNION SELECT 'Software Engineering (SE)', '1st'
    UNION SELECT 'Object Oriented Programming (OOP)', '1st'
    UNION SELECT 'Mobile Application Development (MAD)', '2nd'
    UNION SELECT 'Database Management Systems (DBMS)', '2nd'
    UNION SELECT 'Network Administration (NET)', '2nd'
    UNION SELECT 'Cybersecurity Fundamentals (CSF)', '2nd'
    UNION SELECT 'Cloud Computing (CC)', '2nd'
) sub
WHERE NOT EXISTS (
    SELECT 1 
    FROM grades g 
    WHERE g.student_id = s.id 
    AND g.subject = sub.subject_name 
    AND g.semester = sub.semester
); 