-- Add semester column to grades table if it doesn't exist
ALTER TABLE grades ADD COLUMN IF NOT EXISTS semester VARCHAR(10) DEFAULT '1st' AFTER student_id; 