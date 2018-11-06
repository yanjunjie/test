   $STUDENT_IDs = $this->input->post('STUDENT_ID');
   $CHECKED_STUDENT_IDs = $this->input->post('CHECKED_STUDENT_ID');

   //Unchecked Students
   if(!$CHECKED_STUDENT_IDs)
       $CHECKED_STUDENT_IDs=array();
   if(!$STUDENT_IDs)
       $STUDENT_IDs=array();

   $UNCHECKED_STUDENT_IDs = array_diff($CHECKED_STUDENT_IDs, $STUDENT_IDs);
   //Remove Null, Empty string values but keep 0 and false values
   $UNCHECKED_STUDENT_IDs = array_filter($UNCHECKED_STUDENT_IDs,'strlen');
   foreach ($UNCHECKED_STUDENT_IDs as $UNCHECKED_STUDENT_ID)
   {
       $this->utilities->updateUncheckedStdData('UMS_LAB_SCHEDULE', $UNCHECKED_STUDENT_ID, $sch_data['SDL_DT'], $sch_data['EXP_ID']);
   }
