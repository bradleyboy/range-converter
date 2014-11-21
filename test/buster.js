var config = module.exports;

config["My tests"] = {
    rootPath: "../",
    environment: "node", // or "node"
    tests: [
        "test/cases/*.js"
    ]
}

// Add more configuration groups as needed