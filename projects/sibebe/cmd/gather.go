package cmd

import (
    "fmt"

    "github.com/spf13/cobra"

    "github.com/ktom/sibebe/php/composer"
)

var gatherCmd = &cobra.Command{
    Use: "gather",
    Short: "Gather dependencies from all packages",
    Long: `Long desc`,
    Run: func(cmd *cobra.Command, args []string) {
        jsons := composer.FindComposerJsons("/home/klein/reggae-finder")

        var req = make(composer.ComposerRequirement)
        for _, composer_json := range jsons {
            req = req.Merge(composer_json.Require)
            req = req.Merge(composer_json.RequireDev)
        }

        fmt.Println(req)
        return
    },
}

func init() {
	rootCmd.AddCommand(gatherCmd)
}
