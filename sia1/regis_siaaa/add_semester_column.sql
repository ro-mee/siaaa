-- Add semester column to grades table
ALTER TABLE grades ADD COLUMN semester VARCHAR(10) DEFAULT '1st' AFTER student_id;

-- Update existing records to have '1st' semester
UPDATE grades SET semester = '1st' WHERE semester IS NULL; 