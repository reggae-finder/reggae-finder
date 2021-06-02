package php

import (
    "fmt"
    "github.com/ktom/sibebe/sibebe"
    "path/filepath"
)

// Run the actions defined in .sibebe for each php package
func (p PhpPack) Run(packages []string, clear bool) error {
    numJobs := len(packages)

    runRequests, runResults := make(chan sibebe.RunRequest, numJobs), make(chan sibebe.RunResult, numJobs)

    for w := 0; w < numJobs; w++ {
        go p.runForPackageAsync(runRequests, runResults)
    }

    for _, pathToComposerJson := range packages {
        runRequests <- sibebe.RunRequest{PackageDir: filepath.Dir(pathToComposerJson), Clear: clear}
    }
    close(runRequests)

    jobsResults := []sibebe.RunResult{}

    for i := 0; i < numJobs; i++ {
        jobResult := <-runResults
        jobsResults = append(jobsResults, jobResult)
    }

    for _, jr := range jobsResults {
        fmt.Println("\n\n"+ jr.String())
    }

    return nil
}

func (p PhpPack) runForPackageAsync(jobs <-chan sibebe.RunRequest, results chan<- sibebe.RunResult) {
    for j := range jobs {
        results <- p.runForPackage(j)
    }
}

func (p PhpPack) runForPackage(job sibebe.RunRequest) sibebe.RunResult {
    fmt.Println("Running actions for package", job.PackageDir)

    runResult := sibebe.RunResult{PackageDir: job.PackageDir, ActionResults: make(map[string]sibebe.ActionResult)}

    for _, action := range p.config.GetActions() {
        var actionResult sibebe.ActionResult
        if runnable, ok := p.actions[action]; ok {
            actionResult = runnable(job.PackageDir)
        } else {
            actionResult = sibebe.ActionResult{
                Success: false,
                Error: fmt.Errorf("no action %s registered for php pack", action),
            }
        }
        runResult.Add(actionResult)
    }

    if job.Clear {
        runResult.Add(p.actions["clear"](job.PackageDir))
    }

    return runResult
}



