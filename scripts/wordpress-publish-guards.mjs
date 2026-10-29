export function validateWordPressRelease(event, context, project, version) {
  const repository = 'Jahid07/x-scroll-to-top-responsive';
  if (context.actions !== 'true' || context.eventName !== 'release' || event.action !== 'published'
    || context.repository !== repository || event.repository?.full_name !== repository) {
    throw new Error('Publishing requires this repository\'s GitHub release-published event.');
  }
  const release = event.release;
  if (!release || release.draft !== false || release.prerelease !== false
    || !/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)$/.test(release.tag_name)) {
    throw new Error('Only a published stable X.Y.Z release can publish to WordPress.org.');
  }
  if (release.tag_name !== version || context.ref !== `refs/tags/${version}`) {
    throw new Error('Release tag, GitHub ref, and plugin version must match.');
  }
  if (project.wordpressOrgDeploymentEnabled !== true) throw new Error('WordPress.org publishing is disabled in project.json.');
  if (project.slug !== 'x-scroll-to-top-responsive') throw new Error('Unexpected WordPress.org plugin slug.');
  return version;
}
