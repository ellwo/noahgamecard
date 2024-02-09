const http = require('http');

const { spawn } = require("child_process");

// Define an array of commands and their schedules
const commands = [
    {
        command: "/usr/local/bin/php /home/noahnyuu/tryapi/noahgamecard/artisan queue:work --queue default --stop-when-empty",
        schedule: 60000, // Every one minute (60,000 milliseconds)
    },
    {
        command: "/usr/local/bin/php /home/noahnyuu/tryapi/noahgamecard/artisan queue:work --queue helf_hour --stop-when-empty",
        schedule: 30 * 60 * 1000, // Every 30 minutes (30 * 60 * 1000 milliseconds)
    },
    {
        command: "/usr/local/bin/php /home/noahnyuu/tryapi/noahgamecard/artisan queue:work --queue hourly --stop-when-empty",
        schedule: 60 * 60 * 1000, // Every 1 hour (60 * 60 * 1000 milliseconds)
    },
    {
        command: "/usr/local/bin/php /home/noahnyuu/tryapi/noahgamecard/artisan queue:work --queue hourly_qurter --stop-when-empty",
        schedule: 5 * 60 * 60 * 1000, // Every 5 hours (5 * 60 * 60 * 1000 milliseconds)
    },
];

// Define a function to execute a command
function executeCommand(command) {
    const ls = spawn("sh", ["-c", command]);

    ls.stdout.on("data", data => {
        console.log(`stdout: ${data}`);
    });

    ls.stderr.on("data", data => {
        console.log(`stderr: ${data}`);
    });

    ls.on('error', (error) => {
        console.log(`error: ${error.message}`);
    });

    ls.on("close", code => {
        console.log(`child process exited with code ${code} ${command}`);
    });
}

// Execute each command at its specified schedule

const server = http.createServer((req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.end('Server Is Work --- !\n');
  });


  const port = 80;
server.listen(port, () => {
  console.log(`Server running on port ${port}`);
  commands.forEach(commandInfo => {
    executeCommand(commandInfo.command); // Execute the command initially
    setInterval(() => {
        executeCommand(commandInfo.command); // Execute the command at the specified schedule
    }, commandInfo.schedule);
});

});
