
namespace ButtonHunter
{
    partial class Form1
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
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

        #region Windows Form Designer generated code

        /// <summary>
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            pushButton = new Button();
            statusStrip = new StatusStrip();
            statusLabel = new ToolStripStatusLabel();
            statusStrip.SuspendLayout();
            SuspendLayout();
            // 
            // pushButton
            // 
            pushButton.Location = new Point(360, 226);
            pushButton.Name = "pushButton";
            pushButton.Size = new Size(298, 144);
            pushButton.TabIndex = 0;
            pushButton.Text = "PUSH ME";
            pushButton.UseVisualStyleBackColor = true;
            pushButton.Click += pushButton_Click;
            // 
            // statusStrip
            // 
            statusStrip.ImageScalingSize = new Size(32, 32);
            statusStrip.Items.AddRange(new ToolStripItem[] { statusLabel });
            statusStrip.Location = new Point(0, 618);
            statusStrip.Name = "statusStrip";
            statusStrip.Size = new Size(1097, 42);
            statusStrip.TabIndex = 1;
            statusStrip.ItemClicked += statusStrip_ItemClicked;
            // 
            // statusLabel
            // 
            statusLabel.Name = "statusLabel";
            statusLabel.Size = new Size(383, 32);
            statusLabel.Text = "Click the button to start the game!";
            // 
            // Form1
            // 
            AutoScaleDimensions = new SizeF(13F, 32F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1097, 660);
            Controls.Add(statusStrip);
            Controls.Add(pushButton);
            Name = "Form1";
            Text = "ButtonHunter";
            FormClosing += GameClosing;
            statusStrip.ResumeLayout(false);
            statusStrip.PerformLayout();
            ResumeLayout(false);
            PerformLayout();
        }

        private void statusStrip_ItemClicked(object sender, ToolStripItemClickedEventArgs e)
        {
            throw new NotImplementedException();
        }

        #endregion

        private Button pushButton;
        private StatusStrip statusStrip;
        private ToolStripStatusLabel statusLabel;
    }
}
