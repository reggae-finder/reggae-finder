package sibebe

func (s Sibebe) Update() error {
	PrintVerbose("Updating dependencies for all packages\n")

	for language, pack := range s.packs {
		if packages, ok := s.packagesMap[language]; ok {
			if err := pack.Update(packages); err != nil {
				return err
			}
		} else {
			PrintVerbose("No packages found for language "+ language)
		}
	}

	return nil
}

func Update() error { return s.Update() }