package com.example.alllayouts;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.constraintlayout.widget.Placeholder;

import android.os.Bundle;
import android.transition.TransitionManager;
import android.view.View;

public class ConstraintLayoutTest extends AppCompatActivity {
    private Placeholder placeholder;
    private ConstraintLayout layout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_constraint_layout_test);
        placeholder = findViewById(R.id.placeholder);
        layout = findViewById(R.id.layout);
    }

    public void swapView(View v) {
        TransitionManager.beginDelayedTransition(layout);
        placeholder.setContentId(v.getId());
    }
}
