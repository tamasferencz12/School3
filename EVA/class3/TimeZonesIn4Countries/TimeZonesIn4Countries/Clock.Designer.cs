namespace TimeZonesIn4Countries
{
    partial class Clock
    {
        /// <summary> 
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary> 
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Component Designer generated code

        /// <summary> 
        /// Required method for Designer support - do not modify 
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            cityLabel = new Label();
            timeLabel = new Label();
            SuspendLayout();
            // 
            // cityLabel
            // 
            cityLabel.AutoSize = true;
            cityLabel.Location = new Point(55, 42);
            cityLabel.Name = "cityLabel";
            cityLabel.Size = new Size(126, 32);
            cityLabel.TabIndex = 0;
            cityLabel.Text = "City Name";
            //cityLabel.Click += CityLabel_Click;
            // 
            // timeLabel
            // 
            timeLabel.BorderStyle = BorderStyle.FixedSingle;
            timeLabel.Font = new Font("Segoe UI Black", 10.875F, FontStyle.Bold, GraphicsUnit.Point, 0);
            timeLabel.Location = new Point(55, 100);
            timeLabel.Name = "timeLabel";
            timeLabel.Size = new Size(142, 49);
            timeLabel.TabIndex = 1;
            timeLabel.Text = "HH:MM";
            timeLabel.TextAlign = ContentAlignment.MiddleCenter;
            //timeLabel.Click += timeLabel_Click;
            // 
            // Clock
            // 
            AutoScaleDimensions = new SizeF(13F, 32F);
            AutoScaleMode = AutoScaleMode.Font;
            Controls.Add(timeLabel);
            Controls.Add(cityLabel);
            Name = "Clock";
            Size = new Size(246, 211);
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label cityLabel;
        private Label timeLabel;
    }
}
