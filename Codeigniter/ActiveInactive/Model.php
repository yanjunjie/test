    //Update Unchecked Students data
    public function updateUncheckedStdData($table, $STUDENT_ID, $SDL_DT, $EXP_ID)
    {
        return $this->db->query("
            update $table
            set IS_ATTEND='N', STDNT_IN_TIME='',STDNT_OUT_TIME=''
            where STUDENT_ID='$STUDENT_ID' and SDL_DT='$SDL_DT' and EXP_ID='$EXP_ID'
        ");
    }
