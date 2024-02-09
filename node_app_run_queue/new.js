const http = require('http');
const { exec } = require('child_process');

// Function to execute the command
function runCommand() {
  // Replace the command with your desired command
  exec('ls', (error, stdout, stderr) => {
    if (error) {
      console.error(`Error executing command: ${error}`);
      return;
    }

    console.log(`Command output: ${stdout}`);
  });
}

// Create an HTTP server
const server = http.createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('Hello, world!\n');
});

// Schedule command execution every minute


// Start the server
const port = 80;
server.listen(port, () => {
  console.log(`Server running on port ${port}`);
  setInterval(runCommand, 9000);
});
